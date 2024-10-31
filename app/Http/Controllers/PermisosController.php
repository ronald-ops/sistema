<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Permiso;
use TCPDF;

class PermisosController extends Controller
{
 
   public function mostrarFormulario()
   {
       // Obtener todos los empleados
       $empleados = Empleado::all();

       // Retornar la vista con la lista de empleados
       return view('permisos.generarPermiso', compact('empleados'));
   }

   /**
    * Almacena un nuevo permiso en la base de datos.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse
    */
   public function store(Request $request)
   {
       // Validar los datos del formulario
       $request->validate([
           'empleado_id' => 'required|exists:empleados,id',
           'fecha_entrega' => 'required|date',
           'motivo' => 'required|string|max:255',
           'hora_inicio_permiso' => 'required|date_format:H:i',
           'hora_fin_permiso' => 'required|date_format:H:i',
           'cargo' => 'nullable|string|max:255',
           'oficina' => 'nullable|string|max:255',
           'materia' => 'nullable|string|max:255',
           'reemplazo' => 'nullable|boolean',
           'tipo_permiso' => 'required|string|max:50',
           'otros' => 'nullable|string|max:255',
           'estado' => 'required|string|in:con_boleta,sin_boleta',
       ]);
   
       // Crear un nuevo permiso en la base de datos
       $permiso = Permiso::create([
           'empleado_id' => $request->input('empleado_id'),
           'fecha_entrega' => $request->input('fecha_entrega'),
           'motivo' => $request->input('motivo'),
           'hora_inicio_permiso' => $request->input('hora_inicio_permiso'),
           'hora_fin_permiso' => $request->input('hora_fin_permiso'),
           'cargo' => $request->input('cargo'),
           'oficina' => $request->input('oficina'),
           'materia' => $request->input('materia'),
           'reemplazo' => $request->input('reemplazo', 0),
           'tipo_permiso' => $request->input('tipo_permiso'),
           'otros' => $request->input('otros'),
           'estado' => $request->input('estado'),
       ]);
   
       // Redirigir con un mensaje de éxito
       return redirect()->route('permisos.generarPermiso')->with('success', 'Permiso registrado con éxito.');
   }

    

    /**
     * Genera un reporte PDF de la papeleta de autorización de permiso.
     */
    public function generarReporte()
    {
        // Crear un nuevo documento PDF
        $pdf = new TCPDF(); 
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Instituto Técnico "Nueva Bolivia"');
        $pdf->SetTitle('Papeleta de Autorización de Permiso');
        $pdf->SetSubject('Permiso');

        // Desactivar encabezado y pie de página
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Añadir una página
        $pdf->AddPage();

        // Configurar márgenes
        $pdf->SetMargins(15, 20, 15);
        $pdf->SetAutoPageBreak(TRUE, 10);
        
        // Añadir las papeletas de autorización
        $this->agregarPapeleta($pdf, 10); // Primera papeleta
        $pdf->Ln(30); // Separación entre papeletas
        $this->agregarPapeleta($pdf, $pdf->GetY()); // Segunda papeleta

        // Generar el archivo PDF
        $pdf->Output('Papeleta_Autorizacion_Permiso.pdf', 'D');
    }

    /**
     * Agrega la estructura de una papeleta de permiso al PDF.
     *
     * @param  \TCPDF $pdf
     * @param  float $yPosition
     */
    private function agregarPapeleta($pdf, $yPosition)
    {
        // Calcular la posición X para centrar el logo
        $logoWidth = 20; // Ancho del logo
        $pageWidth = $pdf->GetPageWidth();
        $offset = 75; // Ajuste para mover el logo hacia la izquierda
        $x = ($pageWidth - $logoWidth) / 2 - $offset;

        // Añadir el logo centrado
        $pdf->Image(public_path('vendor/adminlte/dist/img/INB.png'), $x, $yPosition, $logoWidth, '', '', '', '', false, 300, '', false, false, 1, false, false, false);

        // Añadir el nombre del instituto centrado
        $pdf->SetFont('courier', 'B', 10); // Estilo Courier
        $pdf->Cell(0, 5, 'INSTITUTO TÉCNICO "NUEVA BOLIVIA"', 0, 1, 'R', false, '', 0, false, 'T', 'M');

        // Título centrado
        $pdf->SetFont('courier', 'B', 14); // Estilo Courier
        $pdf->Cell(0, 10, 'PAPELETA DE AUTORIZACIÓN DE PERMISO', 0, 1, 'C', false, '', 0, false, 'T', 'M');
        
        // Línea debajo del título
        $x1 = 50; // Coordenada X inicial
        $x2 = 145; // Largo de la línea
        $y1 = $pdf->GetY() - 2; // Posición Y de la línea
        $pdf->Line($x1, $y1, $x2, $y1); // Dibuja la línea

        // Añadir campos de datos del empleado
        $pdf->Ln(5);
        $pdf->SetFont('courier', 'B', 10);
        $pdf->Cell(50, 7, 'APELLIDOS Y NOMBRES:', 1, 0, 'C');
        $pdf->SetFont('courier', '', 10);
        $pdf->Cell(70, 7, '', 1, 0, 'C');
        $pdf->SetFont('courier', 'B', 10);
        $pdf->Cell(20, 7, 'FECHA:', 1, 0, 'C');
        $pdf->SetFont('courier', '', 10);
        $pdf->Cell(40, 7, '', 1, 1, 'C');

        $pdf->SetFont('courier', 'B', 10);
        $pdf->Cell(50, 7, 'CARGO:', 1, 0, 'C');
        $pdf->SetFont('courier', '', 10);
        $pdf->Cell(70, 7, '', 1, 0, 'C');
        $pdf->SetFont('courier', 'B', 10);
        $pdf->Cell(20, 7, 'OFICINA:', 1, 0, 'C');
        $pdf->SetFont('courier', '', 10);
        $pdf->Cell(40, 7, '', 1, 1, 'C');

        // Motivos del permiso
        $pdf->Ln(5);
        $pdf->SetFont('courier', 'B', 10);
        $pdf->Cell(75, 7, 'MOTIVO DE PERMISO', 1, 0, 'C');
        $pdf->Cell(105, 7, 'JUSTIFICACIÓN (Adjuntar respaldo)', 1, 1, 'C');

        $pdf->SetFont('courier', '', 10);
        $pdf->Cell(10, 7, '', 1, 0, 'C');
        $pdf->Cell(65, 7, 'SALUD', 1, 0, 'C');
        $pdf->Cell(105, 7, '', 1, 1, 'C');

        $pdf->Cell(10, 7, '', 1, 0, 'C');
        $pdf->Cell(65, 7, 'PARTICULAR', 1, 0, 'C');
        $pdf->Cell(105, 7, '', 1, 1, 'C');

        $pdf->Cell(10, 7, '', 1, 0, 'C');
        $pdf->Cell(65, 7, 'COMISIÓN', 1, 0, 'C');
        $pdf->Cell(105, 7, '', 1, 1, 'C');

        $pdf->Cell(10, 14, '', 1, 0, 'C');
        $pdf->Cell(65, 14, 'OTROS (Especificar)', 1, 0, 'C');
        $pdf->Cell(105, 14, '', 1, 1, 'C');

        // Horas de salida y llegada
        $pdf->SetFont('courier', '', 10);
        $pdf->Cell(90, 7, 'HORA DE SALIDA:', 1, 0);
        $pdf->Cell(90, 7, 'HORA DE LLEGADA:', 1, 1);

        // Firmas
        $pdf->Ln(5);
        $pdf->Cell(90, 14, 'Solicitado por:', 1, 0);
        $pdf->Cell(90, 14, 'Autorizado por:', 1, 1);
    }
}
