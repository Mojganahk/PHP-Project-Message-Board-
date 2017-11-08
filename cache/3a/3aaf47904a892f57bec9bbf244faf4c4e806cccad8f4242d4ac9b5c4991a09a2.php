<?php

/* admin/categories_addedit.html.twig */
class __TwigTemplate_82722e8c76018880822c73bea11d3a6d6fd6ba9c8fc7e970d023e254459e4202 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "admin/categories_addedit.html.twig", 1);
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
            echo "edit";
        } else {
            echo "add";
        }
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "    ";
        if (($context["errorList"] ?? null)) {
            // line 7
            echo "        <ul>
            ";
            // line 8
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["errorList"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 9
                echo "                <li>";
                echo twig_escape_filter($this->env, $context["error"], "html", null, true);
                echo "</li>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 11
            echo "        </ul>
    ";
        }
        // line 13
        echo "
     <form method=\"post\" enctype=\"multipart/form-data\">
         
        Name: <input type=\"text\" name=\"categoryName\" value=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute(($context["v"] ?? null), "categoryName", array()), "html", null, true);
        echo "\"><br>
        Description: <textarea name=\"description\">";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute(($context["v"] ?? null), "description", array()), "html", null, true);
        echo "</textarea><br>
        <input type=\"file\" name=\"categoryImage\" >
        <input type=\"submit\" value=\"";
        // line 19
        if (($context["isEditing"] ?? null)) {
            echo "Update";
        } else {
            echo "Add";
        }
        echo " category\">
    </form>

";
    }

    public function getTemplateName()
    {
        return "admin/categories_addedit.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 19,  75 => 17,  71 => 16,  66 => 13,  62 => 11,  53 => 9,  49 => 8,  46 => 7,  43 => 6,  40 => 5,  29 => 3,  11 => 1,);
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

{% block title %}Category {% if isEditing %}edit{% else %}add{% endif %}{% endblock %}

{% block content %}
    {% if errorList %}
        <ul>
            {% for error in errorList %}
                <li>{{error}}</li>
                {% endfor %}
        </ul>
    {% endif %}

     <form method=\"post\" enctype=\"multipart/form-data\">
         
        Name: <input type=\"text\" name=\"categoryName\" value=\"{{v.categoryName}}\"><br>
        Description: <textarea name=\"description\">{{v.description}}</textarea><br>
        <input type=\"file\" name=\"categoryImage\" >
        <input type=\"submit\" value=\"{% if isEditing %}Update{% else %}Add{% endif %} category\">
    </form>

{% endblock %}", "admin/categories_addedit.html.twig", "C:\\xampp\\htdocs\\project\\templates\\admin\\categories_addedit.html.twig");
    }
}
