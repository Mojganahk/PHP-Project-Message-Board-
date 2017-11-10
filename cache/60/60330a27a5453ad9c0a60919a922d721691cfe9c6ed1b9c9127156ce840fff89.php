<?php

/* login.html.twig */
class __TwigTemplate_3fcd2ffa7ce8d183f52ff72e39155077eb20417b958de82a602bdbe789ca920d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "login.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "master.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_title($context, array $blocks = array())
    {
        echo "Login";
    }

    // line 7
    public function block_content($context, array $blocks = array())
    {
        // line 8
        echo "

    
    
";
        // line 12
        if ((isset($context["error"]) ? $context["error"] : null)) {
            // line 13
            echo "    <p>Login invalid. Try again or <a href=\"/register\">register</a>.</p>   
";
        }
        // line 15
        echo "
<!--
<form method=\"post\">
    Email: <input type=\"email\" name=\"email\"><br>
    Password: <input type=\"password\" name=\"pass\"><br>
    <input type=\"submit\" value=\"Login\">
</form>
-->


<div class=\"main\">
        <section class=\"module bg-dark-30\" data-background=\"assets/images/section-4.jpg\">
          <div class=\"container\">
            <div class=\"row\">
              <div class=\"col-sm-6 col-sm-offset-3\">
                <h1 class=\"module-title font-alt mb-0\">Login-Register</h1>
              </div>
            </div>
          </div>
        </section>
        <section class=\"module\">
          <div class=\"container\">
            <div class=\"row\">
              <div class=\"col-sm-5 col-sm-offset-1 mb-sm-40\">
                <h4 class=\"font-alt\">Login</h4>
                <hr class=\"divider-w mb-10\">
                <form class=\"form\" method=\"post\" enctype=\"multipart/form-data\">
                  <div class=\"form-group\">
                    <input class=\"form-control\" id=\"email\" type=\"email\" name=\"email\" placeholder=\"email\"/>
                  </div>
                  <div class=\"form-group\">
                    <input class=\"form-control\" id=\"pass\" type=\"password\" name=\"pass\" placeholder=\"Password\"/>
                  </div>
                  <div class=\"form-group\">
                    <button class=\"btn btn-round btn-b\" type=\"submit\" value=\"Login\" >Login</button>
                  </div>
                  <div class=\"form-group\"><a href=\"/passreset/request\">Forgot Password?</a></div>
                </form>
              </div>
                
             
               
            </div>
          </div>
        </section>

 </div>


";
    }

    public function getTemplateName()
    {
        return "login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  50 => 15,  46 => 13,  44 => 12,  38 => 8,  35 => 7,  29 => 4,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"master.html.twig\" %}


{% block title %}Login{% endblock %}
  
    
{% block content %}


    
    
{% if error %}
    <p>Login invalid. Try again or <a href=\"/register\">register</a>.</p>   
{% endif %}

<!--
<form method=\"post\">
    Email: <input type=\"email\" name=\"email\"><br>
    Password: <input type=\"password\" name=\"pass\"><br>
    <input type=\"submit\" value=\"Login\">
</form>
-->


<div class=\"main\">
        <section class=\"module bg-dark-30\" data-background=\"assets/images/section-4.jpg\">
          <div class=\"container\">
            <div class=\"row\">
              <div class=\"col-sm-6 col-sm-offset-3\">
                <h1 class=\"module-title font-alt mb-0\">Login-Register</h1>
              </div>
            </div>
          </div>
        </section>
        <section class=\"module\">
          <div class=\"container\">
            <div class=\"row\">
              <div class=\"col-sm-5 col-sm-offset-1 mb-sm-40\">
                <h4 class=\"font-alt\">Login</h4>
                <hr class=\"divider-w mb-10\">
                <form class=\"form\" method=\"post\" enctype=\"multipart/form-data\">
                  <div class=\"form-group\">
                    <input class=\"form-control\" id=\"email\" type=\"email\" name=\"email\" placeholder=\"email\"/>
                  </div>
                  <div class=\"form-group\">
                    <input class=\"form-control\" id=\"pass\" type=\"password\" name=\"pass\" placeholder=\"Password\"/>
                  </div>
                  <div class=\"form-group\">
                    <button class=\"btn btn-round btn-b\" type=\"submit\" value=\"Login\" >Login</button>
                  </div>
                  <div class=\"form-group\"><a href=\"/passreset/request\">Forgot Password?</a></div>
                </form>
              </div>
                
             
               
            </div>
          </div>
        </section>

 </div>


{% endblock %}




", "login.html.twig", "C:\\xampp\\htdocs\\project\\templates\\login.html.twig");
    }
}
