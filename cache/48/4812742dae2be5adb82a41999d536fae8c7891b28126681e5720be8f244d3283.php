<?php

/* admin/categories_delete.html.twig */
class __TwigTemplate_47bbfb44297720f74109dc37d591860b46e2e2adf2eb33a546eae2d9cc0f8b52 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "admin/categories_delete.html.twig", 1);
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
        echo "Confirm delete";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "    <p><b>Are you sure you want to delete this category?</b></p>
    <form action=\"/admin/categories/list\" style=\"display: inline;\">
        <input type=\"submit\" value=\"Cancel\">
    </form>
    ";
        // line 12
        echo "    <form method=\"post\"  style=\"display: inline;\">
        <input type=\"hidden\" name=\"confirmed\" value=\"true\">
        <input type=\"submit\" value=\"Delete\">
    </form>
    <div>
        <p>Name: ";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute(($context["c"] ?? null), "categoryName", array()), "html", null, true);
        echo "</p>
        <p>Description: ";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute(($context["c"] ?? null), "description", array()), "html", null, true);
        echo "</p>
        <img src=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute(($context["c"] ?? null), "imagePath", array()), "html", null, true);
        echo "\" width=\"100\">
    </div>


";
    }

    public function getTemplateName()
    {
        return "admin/categories_delete.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 19,  55 => 18,  51 => 17,  44 => 12,  38 => 6,  35 => 5,  29 => 3,  11 => 1,);
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

{% block title %}Confirm delete{% endblock %}

{% block content %}
    <p><b>Are you sure you want to delete this category?</b></p>
    <form action=\"/admin/categories/list\" style=\"display: inline;\">
        <input type=\"submit\" value=\"Cancel\">
    </form>
    {# action not requried since we're already on URL looking like
        action=\"/admin/categories/delete/{{c.id}}\" #}
    <form method=\"post\"  style=\"display: inline;\">
        <input type=\"hidden\" name=\"confirmed\" value=\"true\">
        <input type=\"submit\" value=\"Delete\">
    </form>
    <div>
        <p>Name: {{c.categoryName}}</p>
        <p>Description: {{c.description}}</p>
        <img src=\"{{c.imagePath}}\" width=\"100\">
    </div>


{% endblock %}", "admin/categories_delete.html.twig", "C:\\xampp\\htdocs\\project\\templates\\admin\\categories_delete.html.twig");
    }
}
