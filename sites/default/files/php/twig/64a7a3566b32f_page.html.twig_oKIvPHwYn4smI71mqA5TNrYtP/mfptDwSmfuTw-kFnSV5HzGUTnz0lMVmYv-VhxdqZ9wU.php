<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/custom/embark/templates/system/page.html.twig */
class __TwigTemplate_c55d51abf62035e5d0c37290e8e3aff7 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<header aria-label=\"Site header\" class=\"header close-nav\" id=\"header\" role=\"banner\">
<!-- Google tag (gtag.js) -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=G-JF3363LF8C\"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-JF3363LF8C');
</script>
<!--Microsoft Clarity:-->

<script type=\"text/javascript\">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src=\"https://www.clarity.ms/tag/\"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, \"clarity\", \"script\", \"fxldx86dkk\");
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P52LH68');</script>
<!-- End Google Tag Manager -->

<!--google search console-->
<meta name=\"google-site-verification\" content=\"r_3qLFlaPIFnNDL-wlSJaDZYVVXOgnkskCo9vzbg5rA\" />

<div class=\"menu-overlay\"></div>
  <div class=\"wky-container\">
  <div class=\"emb-col-12 emb-col-sm-12 emb-col-lg-12 header-main\">
  <div class=\"social-links-1 d-none d-md-flex align-items-center\" style=\"padding-top:8px;color: #d8d8d8;font-size: 11px;\">
\t\t<a style=\"margin-left:121px\"> <span>India <b>(+91)452-4212111</b></span></a>
\t\t<a style=\"padding-left: 20px;\"> <span>North America <b>(602)399 7883</b></span></a>
    <div class=\"contact-info d-flex align-items-center\">
        <a href=\"https://www.picktime.com/33f48931-875f-440e-832d-a4cdf162a138\" class=\"ptbkbtn\" target=\"_blank\" style=\"float:none;\"><img border=\"none\" style=\"width: 110px;position: absolute;
    right: 0;
    bottom: 0;top:0;
    margin-right: 8%;\" src=\"https://www.picktime.com/img/widgetButtons/BookingPage/picktime-book-online-blue.png\" alt=\"Book an appointment with Embark\"/></a>
  <script>
\t!function(e,t,n,s,i,c){i=t.createElement(n),c=t.getElementsByTagName(n)[0],i.async=1,
\ti.src=s,c.parentNode.insertBefore(i,c)}(window,document,\"script\",\"https://www.picktime.com/assets/booking.js\");
\t</script>
  <script>
\twindow.fwSettings={
\t'widget_id':1070000000180
\t};
\t!function(){if(\"function\"!=typeof window.FreshworksWidget){var n=function(){n.q.push(arguments)};n.q=[],window.FreshworksWidget=n}}()
</script>
<script type='text/javascript' src='https://ind-widget.freshworks.com/widgets/1070000000180.js' async defer></script>
      </div>
  </div>
  </div>
  <hr>
    <div class=\"emb-row align-center\">
      <div class=\"emb-col-3 emb-col-sm-3 emb-col-lg-3\">
        <div class=\"main-logo\">";
        // line 60
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "branding", [], "any", false, false, true, 60), 60, $this->source), "html", null, true);
        echo "</div>
      </div>
      <div class=\"emb-col-9 emb-col-sm-9 emb-col-lg-9\">
        <div class=\"header-right\">
          <div class=\"Ecommerce\">
            <a href=\"/embark/ecommerce\">Ecommerce</a>
          </div>
          <div class=\"digital-marketing\">
            <a href=\"/embark/digital-marketing\">Digital Marketing</a>
          </div>
          <div class=\"technology\">
            <a href=\"/embark/technologies\">Technology</a>
          </div>
          <div class=\"start-up\" style=\"margin-left: 17px;\">
            <a href=\"/embark/startup\">Start Up</a>
          </div>
          <div class=\"growing-business\" style=\"margin-left: 17px;\">
            <a href=\"/embark/growing-business\">Growing Business</a>
          </div>
          <div class=\"careers\" style=\"margin-left: 17px;\">
            <a href=\"/embark/careers\">Careers</a>
          </div>
          <div class=\"blog\" style=\"margin-left: 17px;\">
            <a href=\"/embark/blogs\">Blog</a>
          </div>
          <div class=\"contact-1\" style=\"margin-left: 17px;\">
            <a href=\"/embark/contact\">Contact</a>
          </div>
          <span class=\"ribbon1\"><a href=\"tel:(+91)452-4212111\"><span><b>CALL</b> <br>To Us</span></a></span>
          <div id=\"mySidenav\" class=\"sidenav\">
  <a href=\"javascript:void(0)\" class=\"closebtn\" onclick=\"closeNav()\">&times;</a>
  <img src=\"/images/logo.png\" style=\"margin-left: 36px;\">
  <div class=\"social-links mt-3\">
                        <div class=\"footer-social-media\" style=\"display: flex;
    margin-left: 31px;\">
                            <a class=\"social-icon twitter\" href=\"https://twitter.com\" target=\"_blank\"><img class=\"img-footer\" src=\"/images/twitter1.png\"></a> <a class=\"social-icon facebook\" href=\"https://www.facebook.com\" target=\"_blank\" style=\"padding-left:15px\"><img class=\"img-footer-faceboor\" src=\"/images/facebook1.png\"></a> <a class=\"social-icon instagram\" href=\"https://www.instagram.com/workiyinc/\" target=\"_blank\" style=\"padding-left:15px\"><img class=\"img-footer-insta\" src=\"/images/instagram1.png\"></a><a class=\"social-icon skype\" href=\"https://twitter.com/WorkiyI\" target=\"_blank\" style=\"padding-left:15px\"><img class=\"img-footer-insta\" src=\"/images/skype2.png\" width=\"26\"></a><a class=\"social-icon linkedin\" href=\"https://www.linkedin.com/company/workiy/\" target=\"_blank\" style=\"padding-left:15px\"><img class=\"img-footer-insta\" src=\"/images/linkedd.png\"></a>
                        </div>
                    </div>
  <a href=\"/\">Home</a>
  <a href=\"/ecommerce\">Ecommerce</a>
  <a href=\"/digital-marketing\">Digital marketing</a>
  <a href=\"/technologies\">Technology</a>
  <a href=\"/startup\">Start up</a>
  <a href=\"/growing-business\">Growing Business</a>
  <a href=\"/careers\">Careers</a>
  <a href=\"/blogs\">Blog</a>
  <a href=\"/contact\">Contact</a>
</div>

<div id=\"main-1\">
  <span style=\"font-size:30px;cursor:pointer\" onclick=\"openNav()\">&#9776;</span>
</div>

          <!--<ul>
          <li><a href=\"#\">Ecommerce</a></li>
          <li><a href=\"#\">Digital Marketing</a></li>
          </ul>
          <!--<div class=\"extra\">
                    <button class=\"btn btn-primary\" type=\"button\" data-bs-toggle=\"offcanvas\" data-bs-target=\"#offcanvasRight\" aria-controls=\"offcanvasRight\"><i class=\"fa fa-bars\" aria-hidden=\"true\"></i></button>

<div class=\"offcanvas offcanvas-end\" tabindex=\"-1\" id=\"offcanvasRight\" aria-labelledby=\"offcanvasRightLabel\">
  <div class=\"offcanvas-header\">
    <h5 id=\"offcanvasRightLabel\"></h5>
    <button type=\"button\" class=\"btn-close text-reset\" data-bs-dismiss=\"offcanvas\" aria-label=\"Close\"></button>
  </div>
  <div class=\"offcanvas-body\">
    <div class=\"offcanvas_img\">
    <img src=\"images/logo.svg\">
    </div>
    <div class=\"offcanvas_content\">
    <p>Lorem ipsum dolor sit amet adipisicing elit. Sapiente fuga nisi rerum iusto intro.</p>
    </div>
    <div class=\"offcanvas_links\">
    <h5><b>Quick Links</b></h5>
    <div class=\"offcanvas_ul\">
    <ul>
        <li>About us</li>
        <li>Our Team</li>
        <li>Latest News</li>
        <li>Contact Us</li>
    </ul>
    </div>
    </div>
    <div class=\"offcanvas_icons\">
    <h5><b>Follow Us On</b></h5>
    </div>
  </div>
</div>
                </div>-->
          <!--<div class=\"search\">
            <div class=\"search-icon\"></div>
            <div class=\"search-close\"></div>
            <div class=\"search-content\">";
        // line 152
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "search", [], "any", false, false, true, 152), 152, $this->source), "html", null, true);
        echo "</div>
          </div>-->
          <!--<div class=\"main-navigation\">
            <div class=\"humburger-menu\"></div>
            <div class=\"menu-close\"></div>
            ";
        // line 157
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "navigation", [], "any", false, false, true, 157), 157, $this->source), "html", null, true);
        echo "
          </div>-->

        </div>
      </div>
    </div>
  </div>
</header>
<section class=\"featured\" id=\"featured\" role=\"complementary\">
   ";
        // line 166
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured", [], "any", false, false, true, 166), 166, $this->source), "html", null, true);
        echo "
</section>
<section class=\"main\" id=\"main\">
   <main aria-label=\"Site main content\" class=\"content\" id=\"content\" role=\"main\">
     ";
        // line 170
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 170), 170, $this->source), "html", null, true);
        echo "
   </main>
</section>
<footer aria-label=\"Site footer\" class=\"footer\" id=\"footer\" role=\"contentinfo\">
  <div class=\"footer--top\">
    <div class=\"emb-container\">
      <div class=\"emb-row\">
        <div class=\"emb-col-md-4 emb-col-lg-4 footer-left\">
          <div class=\"footer-left-inner\">
             ";
        // line 179
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 179), 179, $this->source), "html", null, true);
        echo "
          </div>
        </div>
        <div class=\"emb-col-md-8 emb-col-lg-8 footer-right\">
          <div class=\"footer-right-inner\">
             ";
        // line 184
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 184), 184, $this->source), "html", null, true);
        echo "
          </div>
        </div>
        <!-- ";
        // line 187
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_third", [], "any", false, false, true, 187), 187, $this->source), "html", null, true);
        echo " -->
      </div>
    </div>
  <div class=\"footer--bottom\">
    <div class=\"emb-container\">
      <div class=\"emb-row align-center\">
        <div class=\"emb-col-lg-12\">
          ";
        // line 194
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom", [], "any", false, false, true, 194), 194, $this->source), "html", null, true);
        echo "
        </div>
      </div>
    </div>
  </div>
</footer>
";
    }

    public function getTemplateName()
    {
        return "themes/custom/embark/templates/system/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  258 => 194,  248 => 187,  242 => 184,  234 => 179,  222 => 170,  215 => 166,  203 => 157,  195 => 152,  100 => 60,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/embark/templates/system/page.html.twig", "D:\\xampp-8.1.17\\htdocs\\embark\\themes\\custom\\embark\\templates\\system\\page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 60);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
