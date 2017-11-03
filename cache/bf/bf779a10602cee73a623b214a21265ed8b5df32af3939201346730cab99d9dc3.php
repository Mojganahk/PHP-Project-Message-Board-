<?php

/* master.html.twig */
class __TwigTemplate_87a86df006dd2202e643b264156f3e573238b8b43873d898258852522591c01a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'headextra' => array($this, 'block_headextra'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <link href=\"/styles.css\" rel=\"stylesheet\">
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=\"UTF-8\">
        <title>";
        // line 7
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 8
        $this->displayBlock('headextra', $context, $blocks);
        // line 9
        echo "    </head>
    <body>
        <div id=\"centeredContent\">
            ";
        // line 12
        $this->displayBlock('content', $context, $blocks);
        // line 13
        echo "        </div>
        <div class=\"foot\">Footer</div>
    </body>
</html>";
    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        echo "Default";
    }

    // line 8
    public function block_headextra($context, array $blocks = array())
    {
    }

    // line 12
    public function block_content($context, array $blocks = array())
    {
        echo " hello moj";
    }

    public function getTemplateName()
    {
        return "master.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  61 => 12,  56 => 8,  50 => 7,  43 => 13,  41 => 12,  36 => 9,  34 => 8,  30 => 7,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
    <head>
        <link href=\"/styles.css\" rel=\"stylesheet\">
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=\"UTF-8\">
        <title>{% block title %}Default{% endblock %}</title>
        {% block headextra %}{% endblock %}
    </head>
    <body>
        <div id=\"centeredContent\">
            {% block content %} hello moj{% endblock %}
        </div>
        <div class=\"foot\">Footer</div>
    </body>
</html>", "master.html.twig", "C:\\xampp\\htdocs\\ipd10-project\\templates\\master.html.twig");
    }
}
