<?php

class SupportMarkdownTest extends FeaturesTestCase
{
    
    public function test_the_post_content_support_markdown()
    {    	
        $importantText = 'Un texto muy importante';

        $post = $this->createPost([
        		'content' => "La primera parte del texto. **$importantText**. La última parte del texto."
        	]);

        $this->visit($post->url)
        	->seeInElement('strong',$importantText);
    }

    public function test_the_code_in_the_post_is_escaped()
    {
    	$xssAttack="<script>alert('codigo malignoooo');</script>";

    	$post = $this->createPost([
    			'content' => "`$xssAttack` texto normal" //en formato markdown el simbolo ` es para escribir código
    		]);
    	$this->visit($post->url)
    		->dontSee($xssAttack) //see y dontSee ve en el html de la página, sin embargo seeText y dontSeeText ven solo el texto
    		->seeText('texto normal')
    		->seeText($xssAttack);
    }

    public function test_xss_attack()
    {
    	$xssAttack="<script>alert('codigo malignoooo');</script>";

    	$post = $this->createPost([
    			'content' => "$xssAttack texto normal"
    		]);
    	$this->visit($post->url)
    		//->dump()//para hacer un dump del html que se imprime
    		->dontSee($xssAttack) //see y dontSee ve en el html de la página, sin embargo seeText y dontSeeText ven solo el texto
    		->seeText('texto normal')
    		->seeText($xssAttack);
    }

    public function test_xss_attack_with_html()
    {
    	$xssAttack="<img src='img_maligna.jpg'>";

    	$post = $this->createPost([
    			'content' => "$xssAttack texto normal"
    		]);
    	$this->visit($post->url)
    		->dontSee($xssAttack); //see y dontSee ve en el html de la página, sin embargo seeText y dontSeeText ven solo el texto
    }

    public function test_support_markdown_in_comment()
    {
    	$importantText = 'Un texto muy importante en comentario';        

        $comment=factory(\App\Comment::class)->create([
        		'comment' => "Empiezo con... **$importantText** y termino aquí"
        	]);


        $this->visit($comment->post->url)
        	->seeInElement('strong',$importantText);
    }
}
