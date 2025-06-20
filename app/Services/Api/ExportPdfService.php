<?php

namespace App\Services\Api;

use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;

class ExportPdfService {

    public function __construct(private Fpdf $pdf){}

    public function giftCertificate($certificate, $user)
    {
        $pdf = $this->pdf;
        $roomType = $certificate->room_type->name;
        $pdf->SetAutoPageBreak(true, 2);

        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $this->Header();

        //Website 
        $pdf->Ln();
        $pdf->Cell(77, 10, ' ', 0, 0);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(20, 10, 'Website', 0, 0);
        $pdf->Cell(5, 10, ':', 0, 0, 'C');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(100, 10, 'https://infinity-hotel.com',  0, 0);

        //Email 
        $pdf->Ln();
        $pdf->Cell(77, 10, ' ', 0, 0);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(20, 10, 'Email', 0, 0);
        $pdf->Cell(5, 10, ':', 0, 0, 'C');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(100, 10, $user->email, 0, 0);

        //Divider 
        $pdf->Ln();
        $pdf->SetLineWidth(.5);
        $pdf->Line(10, 50, 198, 50);

        //Reminder
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(35, 10, 'Reminder : ', 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(100, 10, 'This gift certificate is valid from ' . $certificate->start_date . ' to ' . $certificate->end_date . '. Please redeem it ');
        $pdf->Ln();
        $pdf->Cell(35, 10, '', 0);
        $pdf->Cell(100, 10, 'within the validity period. Expired certificates will not be accepted.', );

        //Room Type Image
        $pdf->Ln();
        $this->RoomType($roomType);
        $pdf->Ln();
        $pdf->Cell(180, 80, '');

        //Room Type
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(45, 10 , 'Room Type');
        $pdf->Cell(5, 10, ':');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(80, 10, $roomType);

        //Gift Certificate
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(45, 10 , 'Gift Certificate');
        $pdf->Cell(5, 10, ':');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(80, 10, $certificate->name);

        //Description
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(45, 10 , 'Description');
        $pdf->Cell(5, 10, ':');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(80, 10, $certificate->description);

        //Start Date
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(45, 10 , 'Valid From');
        $pdf->Cell(5, 10, ':');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(80, 10, $certificate->start_date);

         //Start Date
         $pdf->Ln();
         $pdf->SetFont('Arial', 'B', 14);
         $pdf->Cell(45, 10 , 'Valid To');
         $pdf->Cell(5, 10, ':');
         $pdf->SetFont('Arial', '', 12);
         $pdf->Cell(80, 10, $certificate->end_date);

        //Footer
        $this->Footer();
        $pdf->Output();
        exit;
    }

    /**
     * 
     * PRIVATE METHODS 
     * 
     */

     private function Header(): void
    {
        $this->pdf->Image("https://raw.githubusercontent.com/whodatboi04/my-portfolio-rydev/refs/heads/main/public/infinity.png", 20, 6, 40);
        $this->pdf->SetFont('Arial','B',16);             
        $this->pdf->Cell(190,10,'Infinity Hotel', 0, 0, 'C');
    }

    private function RoomType($roomType): void
    {
        match($roomType){
            'Executive' =>  $this->pdf->Image('https://i.pinimg.com/736x/e6/30/db/e630db9e931df9ea09a6090cf5dbfa89.jpg', 28, 80, 150, 70),
            'Queen Room' =>  $this->pdf->Image('https://i.pinimg.com/736x/6e/ac/2a/6eac2ae7668708f5c306d6030a557d78.jpg', 28, 80, 150, 70),
            'Deluxe Room' =>  $this->pdf->Image('https://i.pinimg.com/736x/94/22/d7/9422d7ecc32a8c6af5d538ef38316de2.jpg', 28, 80, 150, 70),
            'Double Room' =>  $this->pdf->Image('https://i.pinimg.com/736x/04/fc/eb/04fceb65df1c019e9915df2f681b5989.jpg', 28, 80, 150, 70),
            'Standard Room' =>  $this->pdf->Image('https://i.pinimg.com/736x/b2/2a/ec/b22aec02ecd50042053a51886ad30c24.jpg', 28, 80, 150, 70),
        };
    }

    private function Footer(): void
    {
        $this->pdf->SetY(-20);
        $this->pdf->SetFont('Arial','I',10);
        $this->pdf->Cell(40, 5, 'Esperanza Street, corner Makati Ave,');
        $this->pdf->Cell(82, 5, '');
        $this->pdf->SetFont('Arial','I',8);
        $this->pdf->Cell(82, 5, 'Designed & Developed by Ryan Mark Delos Reyes');
        $this->pdf->Ln();
        $this->pdf->Cell(60, 5, 'Ayala Center, Makati City, Metro Manila  ');
        $this->pdf->Image("https://raw.githubusercontent.com/whodatboi04/my-portfolio-rydev/refs/heads/main/public/infinity.png", 100, 276, 10);
    }

}