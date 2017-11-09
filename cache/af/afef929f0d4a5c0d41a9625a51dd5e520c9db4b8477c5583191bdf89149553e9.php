<?php

/* register.html.twig */
class __TwigTemplate_f3f20d9434dbcd3da2761f011da04e05a187c0cd3f0af5fbc8d33d5e1510fcc5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "register.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'headextra' => array($this, 'block_headextra'),
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
        echo "Register";
    }

    // line 5
    public function block_headextra($context, array $blocks = array())
    {
        // line 6
        echo "    <script>
        \$(document).ready(function () {
            // respond to all events that may change the value of input
            \$('input[name=email]').bind('propertychange change click keyup input paste', function () {
                // AJAX request
                var email = \$('input[name=email]').val();
                \$('#isTaken').load('/isemailregistered/' + email);
            });
        });
    </script>
";
    }

    // line 18
    public function block_content($context, array $blocks = array())
    {
        // line 19
        echo "    ";
        if (($context["errorList"] ?? null)) {
            // line 20
            echo "        <ul>
            ";
            // line 21
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["errorList"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 22
                echo "                <li>";
                echo twig_escape_filter($this->env, $context["error"], "html", null, true);
                echo "</li>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 24
            echo "        </ul>
    ";
        }
        // line 26
        echo "
    <form method=\"post\">
        Name: <input type=\"text\" name=\"name\" value=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->getAttribute(($context["v"] ?? null), "name", array()), "html", null, true);
        echo "\"><br>
        Email: <input type=\"email\" name=\"email\" value=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute(($context["v"] ?? null), "email", array()), "html", null, true);
        echo "\"><span id=\"isTaken\"></span><br>
        Password: <input type=\"password\" name=\"pass1\"><br>
        Password (repeated): <input type=\"password\" name=\"pass2\"><br>
        <input type=\"submit\" value=\"Register\">
    </form>

";
    }

    public function getTemplateName()
    {
        return "register.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 29,  83 => 28,  79 => 26,  75 => 24,  66 => 22,  62 => 21,  59 => 20,  56 => 19,  53 => 18,  39 => 6,  36 => 5,  30 => 3,  11 => 1,);
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

{% block title %}Register{% endblock %}

{% block headextra %}
    <script>
        \$(document).ready(function () {
            // respond to all events that may change the value of input
            \$('input[name=email]').bind('propertychange change click keyup input paste', function () {
                // AJAX request
                var email = \$('input[name=email]').val();
                \$('#isTaken').load('/isemailregistered/' + email);
            });
        });
    </script>
{% endblock %}

{% block content %}
    {% if errorList %}
        <ul>
            {% for error in errorList %}
                <li>{{error}}</li>
                {% endfor %}
        </ul>
    {% endif %}

    <form method=\"post\">
        Name: <input type=\"text\" name=\"name\" value=\"{{v.name}}\"><br>
        Email: <input type=\"email\" name=\"email\" value=\"{{v.email}}\"><span id=\"isTaken\"></span><br>
        Password: <input type=\"password\" name=\"pass1\"><br>
        Password (repeated): <input type=\"password\" name=\"pass2\"><br>
        <input type=\"submit\" value=\"Register\">
    </form>

{% endblock %}", "register.html.twig", "C:\\xampp\\htdocs\\project\\templates\\register.html.twig");
    }
}
