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
    private $cor_fundo;//background-color

    private $letra_familia;//font-family
    private $letra_tamanho;//font-size
    private $letra_tipo;//font-weight

    private $contorno;//mostra um contorno para todas as BOX
    //===============================================================================================
    public function __construct($contorno=false, $formato='A4', $orientacao='P', $modo='utf-8')
    {
        // criar a instância da classe Mpdf
        $this->pdf = new Mpdf(['format'=>$formato, 'orientation'=>$orientacao, 'mode'=>$modo]);
        //iniciar o html
        $this->iniciar_html();
        //ao instanciar a classe - new PDF(true/false)(para mostar ou não o contorno)
        $this->contorno=$contorno;
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
    public function guardar_pdf($nome_arquivo)
    {
        //guardar o ficheiro para um arquivo .pdf
        $this->pdf->WriteHTML($this->html);
        $this->pdf->Output(PDF_PATH.$nome_arquivo);
    }
    //===============================================================================================
    public function set_template($template)
    {
        //define um template(pdf) para ser usado como fundo do nosso pdf final
        $this->pdf->SetDocTemplate($template);
    }
    //===============================================================================================
    public function nova_pagina()
    {
        //acrescentar uma nova pagina ao pdf
        $this->html .= '<pagebreak>';
    }
    //===============================================================================================
    // métodos para definir posição e dimensão do texto
    //===============================================================================================
    public function set_x($x)
    {
        $this->x=$x;
    }
    //===============================================================================================
    public function set_y($y)
    {
        $this->y=$y;
    }
    //===============================================================================================
    public function posicao($x, $y)
    {
        $this->x=$x;
        $this->y=$y;
    }
    //===============================================================================================
    public function largura($largura)
    {
        $this->largura=$largura;
    }
    //===============================================================================================
    public function altura($altura)
    {
        $this->altura=$altura;
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
    public function cor_text($cor)
    {
        $this->cor=$cor;
    }
    //===============================================================================================
    public function cor_fundo($cor_fundo)
    {
        $this->cor_fundo=$cor_fundo;
    }
    //===============================================================================================
    public function text_align($align)
    {
        $this->alinhamento=$align;
    }
    //===============================================================================================
    public function set_font_family($familia)
    {
        $familia_possiveis=['Courier New','Arial','Franklin Gothic Medium','Lucida Sans','Times New Roman'];
        // verifica se $familia pertence ao conjunto de letras permitidos
        if(!in_array($familia, $familia_possiveis)){
            $this->letra_familia='Arial';
        }else{
            $this->letra_familia=$familia;
        }
    }
    //===============================================================================================
    public function font_size($tamanho)
    {
        $this->letra_tamanho=$tamanho;
    }
    //===============================================================================================
    public function letra_espessura($espessura)
    {
        $this->letra_tipo=$espessura;
    }
    //===============================================================================================
    public function set_permissoes($permissoes=[], $password='')
    {
        //define permissões para o documento pdf a ser criado
        $this->pdf->SetProtection($permissoes, $password);
    }
    //===============================================================================================
    public function escrever($texto)
    {
        //escreve texto no documento HTML
        $this->html .= '<div style="';
        $this->html .= 'position: absolute;';
        // posição e dimensão
        $this->html .= 'left:'.$this->x.'px;';
        $this->html .= 'top:'.$this->y.'px;';
        $this->html .= 'width:'.$this->largura.'px;';
        $this->html .= 'height:'.$this->altura.'px;';
        $this->html .= 'text-align:'.$this->alinhamento.';';
        // cor de fundo
        $this->html .= 'background-color:'.$this->cor_fundo.';';
        //fontes - cor - estilos
        $this->html .= 'color:'.$this->cor.';';
        $this->html .= 'font-family:'.$this->letra_familia.';';
        $this->html .= 'font-size:'.$this->letra_tamanho.';';
        $this->html .= 'font-weight:'.$this->letra_tipo.';';
        
        //mostrar area de contorno
        if($this->contorno){
            $this->html .= 'box-shadow: inset 0px 0px 0px 1px #000;';
        }

        $this->html .= '">'.$texto.'</div>';
        // return $this->html;
    }
}