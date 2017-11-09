<?php

/* admin/categories_delete_success.html.twig */
class __TwigTemplate_9e8c7d1d6f10bebaeb97cc939c2997ae04ff44288b2bfdba3ab776466f8eafa3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "admin/categories_delete_success.html.twig", 1);
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
        echo "Category delete";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo "    
    <p>Category deleted. <a href=\"/admin/categories/list\">Click to continue</a>.</p>
";
    }

    public function getTemplateName()
    {
        return "admin/categories_delete_success.html.twig";
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

{% block title %}Category delete{% endblock %}

{% block content %}    
    <p>Category deleted. <a href=\"/admin/categories/list\">Click to continue</a>.</p>
{% endblock %}", "admin/categories_delete_success.html.twig", "C:\\xampp\\htdocs\\project\\templates\\admin\\categories_delete_success.html.twig");
    }
}
