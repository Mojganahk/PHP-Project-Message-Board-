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
            'content' => array($this, 'block_content'),
            'UserIDentification' => array($this, 'block_UserIDentification'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en-US\" dir=\"ltr\">

    <head>
        <link href=\"/styles.css\" rel=\"stylesheet\">

        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">

        <!--  ================== JavaScripts   ======================================-->
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
        <script src=\"assets/lib/jquery/dist/jquery.js\"></script>
        <script src=\"assets/lib/bootstrap/dist/js/bootstrap.min.js\"></script>
        <script src=\"assets/lib/wow/dist/wow.js\"></script>
        <script src=\"assets/lib/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.js\"></script>
        <script src=\"assets/lib/isotope/dist/isotope.pkgd.js\"></script>
        <script src=\"assets/lib/imagesloaded/imagesloaded.pkgd.js\"></script>
        <script src=\"assets/lib/flexslider/jquery.flexslider.js\"></script>
        <script src=\"assets/lib/owl.carousel/dist/owl.carousel.min.js\"></script>
        <script src=\"assets/lib/smoothscroll.js\"></script>
        <script src=\"assets/lib/magnific-popup/dist/jquery.magnific-popup.js\"></script>
        <script src=\"assets/lib/simple-text-rotator/jquery.simple-text-rotator.min.js\"></script>
        <script src=\"assets/js/plugins.js\"></script>
        <script src=\"assets/js/main.js\"></script>
        <meta http-equiv=\"Content-Type\" content=\"text/html\" charset=\"UTF-8\">
        <!-- Default stylesheets-->
        <link href=\"assets/lib/bootstrap/dist/css/bootstrap.min.css\" rel=\"stylesheet\">
        <!-- Template specific stylesheets-->
        <link href=\"https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css?family=Volkhov:400i\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800\" rel=\"stylesheet\">
        <link href=\"assets/lib/animate.css/animate.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/components-font-awesome/css/font-awesome.min.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/et-line-font/et-line-font.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/flexslider/flexslider.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/owl.carousel/dist/assets/owl.carousel.min.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/owl.carousel/dist/assets/owl.theme.default.min.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/magnific-popup/dist/magnific-popup.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/simple-text-rotator/simpletextrotator.css\" rel=\"stylesheet\">
        <link href=\"assets/css/style.css\" rel=\"stylesheet\">
        <title>";
        // line 41
        $this->displayBlock('title', $context, $blocks);
        echo "</title>

    </head>

   
  
<body>
         <nav class=\"navbar navbar-custom navbar-fixed-top navbar-transparent\" role=\"navigation\">
            <div class=\"container\">
                <div class=\"navbar-header\">
                    <button class=\"navbar-toggle\" type=\"button\" data-toggle=\"collapse\" data-target=\"#custom-collapse\">
                        <span class=\"sr-only\">Toggle navigation</span><span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span><span class=\"icon-bar\"></span></button><a class=\"navbar-brand\" href=\"index.html\">Forum</a>
                </div>
                <div class=\"collapse navbar-collapse\" id=\"custom-collapse\">
                    <ul class=\"nav navbar-nav navbar-right\">
                        <li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\">Home</a>
                         </li>
                        <li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\">Categories</a>
                        </li>
                            <li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\">Posts</a>
                        </li>
                        <li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\">Login</a>
                            <ul class=\"dropdown-menu\">
                                   
                                <li><a href=\"/login\"> Login  </a></li>
                                <li><a href=\"/register\">Register</a></li>
                                <li><a href=\"404.html\">Page 404</a></li>
                            </ul>
                        </li>
             </ul>
                </div>
            </div>
        </nav>
    <div class=\"page-loader\">
        <div class=\"loader\">Loading...</div> 
        
    </div>
  
";
        // line 80
        $this->displayBlock('content', $context, $blocks);
        // line 107
        echo "


        ";
        // line 110
        $this->displayBlock('footer', $context, $blocks);
        // line 130
        echo "</body>
</html>";
    }

    // line 41
    public function block_title($context, array $blocks = array())
    {
        echo "Default";
    }

    // line 80
    public function block_content($context, array $blocks = array())
    {
        // line 81
        echo "
<section class=\"home-section home-parallax home-fade home-full-height bg-dark-30\" id=\"home\" data-background=\"assets/images/section-1.jpg\">
    <div class=\"main\">


      ";
        // line 86
        $this->displayBlock('UserIDentification', $context, $blocks);
        // line 97
        echo "



    </div>
    
</section>
    
      
";
    }

    // line 86
    public function block_UserIDentification($context, array $blocks = array())
    {
        // line 87
        echo "       
            ";
        // line 88
        if ((isset($context["userSession"]) ? $context["userSession"] : null)) {
            // line 89
            echo "                <p>Hello ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["userSession"]) ? $context["userSession"] : null), "name", array()), "html", null, true);
            echo ", You are Logged in.
                    You may <a href=\"/logout\">logout</a></p>
                ";
        } else {
            // line 92
            echo "                <p>You're not logged in. You may <a href=\"/register\">Register</a>
                    or <a href=\"/login\">Login</a>.</p>
                ";
        }
        // line 95
        echo "        
    ";
    }

    // line 110
    public function block_footer($context, array $blocks = array())
    {
        // line 111
        echo "
            <footer class=\"footer bg-dark\">
                <div class=\"container\">
                    <div class=\"row\">
                        <div class=\"col-sm-6\">
                            <p class=\"copyright font-alt\">&copy; 2017&nbsp;<a href=\"index.html\">Forum</a>, All Rights Reserved</p>
                        </div>
                        <div class=\"col-sm-6\">
                            <div class=\"footer-social-links\"><a href=\"#\">
                                    <i class=\"fa fa-facebook\"></i></a>
                                    <a href=\"#\"><i class=\"fa fa-twitter\">
                                        
                                    </i></a><a href=\"#\"><i class=\"fa fa-skype\"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        ";
    }

    public function getTemplateName()
    {
        return "master.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  180 => 111,  177 => 110,  172 => 95,  167 => 92,  160 => 89,  158 => 88,  155 => 87,  152 => 86,  139 => 97,  137 => 86,  130 => 81,  127 => 80,  121 => 41,  116 => 130,  114 => 110,  109 => 107,  107 => 80,  65 => 41,  23 => 1,);
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
<html lang=\"en-US\" dir=\"ltr\">

    <head>
        <link href=\"/styles.css\" rel=\"stylesheet\">

        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">

        <!--  ================== JavaScripts   ======================================-->
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
        <script src=\"assets/lib/jquery/dist/jquery.js\"></script>
        <script src=\"assets/lib/bootstrap/dist/js/bootstrap.min.js\"></script>
        <script src=\"assets/lib/wow/dist/wow.js\"></script>
        <script src=\"assets/lib/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.js\"></script>
        <script src=\"assets/lib/isotope/dist/isotope.pkgd.js\"></script>
        <script src=\"assets/lib/imagesloaded/imagesloaded.pkgd.js\"></script>
        <script src=\"assets/lib/flexslider/jquery.flexslider.js\"></script>
        <script src=\"assets/lib/owl.carousel/dist/owl.carousel.min.js\"></script>
        <script src=\"assets/lib/smoothscroll.js\"></script>
        <script src=\"assets/lib/magnific-popup/dist/jquery.magnific-popup.js\"></script>
        <script src=\"assets/lib/simple-text-rotator/jquery.simple-text-rotator.min.js\"></script>
        <script src=\"assets/js/plugins.js\"></script>
        <script src=\"assets/js/main.js\"></script>
        <meta http-equiv=\"Content-Type\" content=\"text/html\" charset=\"UTF-8\">
        <!-- Default stylesheets-->
        <link href=\"assets/lib/bootstrap/dist/css/bootstrap.min.css\" rel=\"stylesheet\">
        <!-- Template specific stylesheets-->
        <link href=\"https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css?family=Volkhov:400i\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800\" rel=\"stylesheet\">
        <link href=\"assets/lib/animate.css/animate.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/components-font-awesome/css/font-awesome.min.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/et-line-font/et-line-font.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/flexslider/flexslider.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/owl.carousel/dist/assets/owl.carousel.min.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/owl.carousel/dist/assets/owl.theme.default.min.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/magnific-popup/dist/magnific-popup.css\" rel=\"stylesheet\">
        <link href=\"assets/lib/simple-text-rotator/simpletextrotator.css\" rel=\"stylesheet\">
        <link href=\"assets/css/style.css\" rel=\"stylesheet\">
        <title>{% block title %}Default{% endblock %}</title>

    </head>

   
  
<body>
         <nav class=\"navbar navbar-custom navbar-fixed-top navbar-transparent\" role=\"navigation\">
            <div class=\"container\">
                <div class=\"navbar-header\">
                    <button class=\"navbar-toggle\" type=\"button\" data-toggle=\"collapse\" data-target=\"#custom-collapse\">
                        <span class=\"sr-only\">Toggle navigation</span><span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span><span class=\"icon-bar\"></span></button><a class=\"navbar-brand\" href=\"index.html\">Forum</a>
                </div>
                <div class=\"collapse navbar-collapse\" id=\"custom-collapse\">
                    <ul class=\"nav navbar-nav navbar-right\">
                        <li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\">Home</a>
                         </li>
                        <li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\">Categories</a>
                        </li>
                            <li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\">Posts</a>
                        </li>
                        <li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\">Login</a>
                            <ul class=\"dropdown-menu\">
                                   
                                <li><a href=\"/login\"> Login  </a></li>
                                <li><a href=\"/register\">Register</a></li>
                                <li><a href=\"404.html\">Page 404</a></li>
                            </ul>
                        </li>
             </ul>
                </div>
            </div>
        </nav>
    <div class=\"page-loader\">
        <div class=\"loader\">Loading...</div> 
        
    </div>
  
{% block content %}

<section class=\"home-section home-parallax home-fade home-full-height bg-dark-30\" id=\"home\" data-background=\"assets/images/section-1.jpg\">
    <div class=\"main\">


      {% block UserIDentification %}
       
            {% if userSession %}
                <p>Hello {{ userSession.name }}, You are Logged in.
                    You may <a href=\"/logout\">logout</a></p>
                {% else %}
                <p>You're not logged in. You may <a href=\"/register\">Register</a>
                    or <a href=\"/login\">Login</a>.</p>
                {% endif %}
        
    {% endblock %}




    </div>
    
</section>
    
      
{% endblock %}



        {% block footer %}

            <footer class=\"footer bg-dark\">
                <div class=\"container\">
                    <div class=\"row\">
                        <div class=\"col-sm-6\">
                            <p class=\"copyright font-alt\">&copy; 2017&nbsp;<a href=\"index.html\">Forum</a>, All Rights Reserved</p>
                        </div>
                        <div class=\"col-sm-6\">
                            <div class=\"footer-social-links\"><a href=\"#\">
                                    <i class=\"fa fa-facebook\"></i></a>
                                    <a href=\"#\"><i class=\"fa fa-twitter\">
                                        
                                    </i></a><a href=\"#\"><i class=\"fa fa-skype\"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        {% endblock %}
</body>
</html>", "master.html.twig", "C:\\xampp\\htdocs\\project\\templates\\master.html.twig");
    }
}
