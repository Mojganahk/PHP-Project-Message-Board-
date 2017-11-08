<?php

/* admin/categories_addedit_success.html.twig */
class __TwigTemplate_768aeaf9e20972e920115383b9e6e9791896c0a80e6244db64bca5fba3f2bc6c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "admin/categories_addedit_success.html.twig", 1);
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
        echo "Category ";
        if (($context["isEditing"] ?? null)) {
            echo "update";
        } else {
            echo "add";
        }
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo "    
    <p>Category ";
        // line 6
        if (($context["isEditing"] ?? null)) {
            echo "updated";
        } else {
            echo "added";
        }
        echo ".
        <a href=\"/admin/categories/list\">Click to continue</a>.</p>
";
    }

    public function getTemplateName()
    {
        return "admin/categories_addedit_success.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  45 => 6,  40 => 5,  29 => 3,  11 => 1,);
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

{% block title %}Category {% if isEditing %}update{% else %}add{% endif %}{% endblock %}

{% block content %}    
    <p>Category {% if isEditing %}updated{% else %}added{% endif %}.
        <a href=\"/admin/categories/list\">Click to continue</a>.</p>
{% endblock %}", "admin/categories_addedit_success.html.twig", "C:\\xampp\\htdocs\\project\\templates\\admin\\categories_addedit_success.html.twig");
    }
}
