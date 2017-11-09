<?php

/* access_denied.html.twig */
class __TwigTemplate_89c509f0d18a1d2180929fef1162c9caaeaf93ec47751b0836d387afabf92d0f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "access_denied.html.twig", 1);
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

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Access denied";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo "  
<p>Access denied. <a href=\"/\">Click to continue</a>.</p>
";
    }

    public function getTemplateName()
    {
        return "access_denied.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 5,  29 => 3,  11 => 1,);
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

{% block title %}Access denied{% endblock %}

{% block content %}  
<p>Access denied. <a href=\"/\">Click to continue</a>.</p>
{% endblock %}", "access_denied.html.twig", "C:\\xampp\\htdocs\\project\\templates\\access_denied.html.twig");
    }
}
