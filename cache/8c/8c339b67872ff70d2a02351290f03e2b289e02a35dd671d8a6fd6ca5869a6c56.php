<?php

/* admin/categories_list.html.twig */
class __TwigTemplate_12f9fe6dffd14755521aacef949703b1002fd88b68b9ee268de362fb3f718360 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.html.twig", "admin/categories_list.html.twig", 1);
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
        echo "Categories list";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "    <p><a href=\"/admin/categories/add\">Add category</a></p>
    <table border=\"1\">
        <tr><th>#</th><th>name</th><th>description</th><th>image</th><th>actions</th></tr>
    ";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["list"] ?? null));
        $context['_iterated'] = false;
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 10
            echo "            <tr class=\"";
            if (($this->getAttribute($context["loop"], "index", array()) % 2 == 1)) {
                echo "rowodd";
            } else {
                echo "roweven";
            }
            echo "\">
                <td>";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 12
            echo twig_escape_filter($this->env, $this->getAttribute($context["c"], "categoryName", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 13
            echo twig_escape_filter($this->env, $this->getAttribute($context["c"], "description", array()), "html", null, true);
            echo "</td>
                <td><img src=\"";
            // line 14
            echo twig_escape_filter($this->env, $this->getAttribute($context["c"], "imagePath", array()), "html", null, true);
            echo "\" width=\"100\"></td>
                <td>
                    <a href=\"/admin/categories/delete/";
            // line 16
            echo twig_escape_filter($this->env, $this->getAttribute($context["c"], "id", array()), "html", null, true);
            echo "\">Delete</a>
                    <a href=\"/admin/categories/edit/";
            // line 17
            echo twig_escape_filter($this->env, $this->getAttribute($context["c"], "id", array()), "html", null, true);
            echo "\">Edit</a>
                </td></tr>
    ";
            $context['_iterated'] = true;
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        if (!$context['_iterated']) {
            // line 20
            echo "        <tr><td colspan=\"6\">You have no categories</td></tr>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 22
        echo "    </table>
    
";
    }

    public function getTemplateName()
    {
        return "admin/categories_list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  114 => 22,  107 => 20,  91 => 17,  87 => 16,  82 => 14,  78 => 13,  74 => 12,  70 => 11,  61 => 10,  43 => 9,  38 => 6,  35 => 5,  29 => 3,  11 => 1,);
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

{% block title %}Categories list{% endblock %}

{% block content %}
    <p><a href=\"/admin/categories/add\">Add category</a></p>
    <table border=\"1\">
        <tr><th>#</th><th>name</th><th>description</th><th>image</th><th>actions</th></tr>
    {% for c in list %}
            <tr class=\"{% if loop.index is odd %}rowodd{% else %}roweven{% endif %}\">
                <td>{{loop.index}}</td>
                <td>{{c.categoryName}}</td>
                <td>{{c.description}}</td>
                <td><img src=\"{{c.imagePath}}\" width=\"100\"></td>
                <td>
                    <a href=\"/admin/categories/delete/{{c.id}}\">Delete</a>
                    <a href=\"/admin/categories/edit/{{c.id}}\">Edit</a>
                </td></tr>
    {% else %}
        <tr><td colspan=\"6\">You have no categories</td></tr>
    {% endfor %}
    </table>
    
{% endblock %}", "admin/categories_list.html.twig", "C:\\xampp\\htdocs\\project\\templates\\admin\\categories_list.html.twig");
    }
}
