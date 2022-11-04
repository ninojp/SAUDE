<?php
namespace core\classes;
use Mpdf\Mpdf;

//===================================================================================================
class PDF
{
    private $pdf;
    private $html;

    private $x; //left
    private $y; //top
    private $largura;//width
    private $altura;//height
    private $alinhamento;//text-align

    private $cor; //font-color
    private $fundo;//background-color

    private $letra_familia;//font-family
    private $letra_tamanho;//font-size
    private $letra_tipo;//font-weight

    //===============================================================================================
    public function __construct($formato='A4', $orientacao='P', $modo='utf-8')
    {
        // criar a instância da classe Mpdf
        $this->pdf = new Mpdf(['format'=>$formato, 'orientation'=>$orientacao, 'mode'=>$modo]);
        //iniciar o html
        $this->iniciar_html();
    }
    //===============================================================================================
    public function set_template($template)
    {
        $this->pdf->SetDocTemplate($template);
    }
    //===============================================================================================
    public function iniciar_html()
    {
        //coloca o html em branco
        $this->html='';
    }
    //===============================================================================================
    public function apresentar_pdf()
    {
        //output para o browser ou para um arquivo .pdf
        $this->pdf->WriteHTML($this->html);
        $this->pdf->Output();
    }
    //===============================================================================================
    public function nova_pagina()
    {
        //acrescentar uma nova pagina ao pdf
        $this->html .= '<pagebreak>';

    }
    //===============================================================================================
    public function escrever($texto)
    {
        //escreve texto no documento
        // $this->html .= "<div style='color:green;font-size:30pt'>Texto de teste: </div>";
        $this->html .= $texto;
    }
    //===============================================================================================
    // métodos para definir posição e dimanção do texto
    // NO VIDEO 99 e 100 DA PLAYLIST WEBSTORE - agora já entendi pq KKKKKKKKKKKKKKKKKKK
    //  eu não construi TODOS os metodos ensinados - vou PULAR por enquanto achei desnecessário
    //===============================================================================================
    public function posicao($x, $y)
    {
        $this->x=$x;
        $this->y=$y;
    }
    //===============================================================================================
    public function dimensao($largura, $altura)
    {
        $this->largura=$largura;
        $this->altura=$altura;
    }
    //===============================================================================================
    public function posicao_dimensao($x, $y, $largura, $altura)
    {
        $this->posicao($x, $y);
        $this->dimensao($largura, $altura);
    }
    //===============================================================================================
    
}