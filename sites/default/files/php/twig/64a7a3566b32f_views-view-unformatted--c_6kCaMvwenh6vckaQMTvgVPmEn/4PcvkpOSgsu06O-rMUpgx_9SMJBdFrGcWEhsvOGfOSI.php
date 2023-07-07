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

/* themes/custom/embark/templates/views/views-view-unformatted--clients--homeclients.html.twig */
class __TwigTemplate_f0082f99fee2019f3312ff68378da01e extends Template
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
        // line 21
        $context["row_classes"] = [0 => ((        // line 22
($context["default_row_class"] ?? null)) ? ("views-row") : (""))];
        // line 25
        echo "<section id=\"our-clients\">
    <div class=\"emb-container\">
        <div class=\"hint-text\"><h2 style=\"padding-top:60px\">Our Clients<h2></div>
        <h5 class=\"heading\"><span class=\"light\">Growth Rocket is the agency of choice for a diverse roster of clients. We have driven results for<br>emerging brands in South East Asia to big businesses in the US, Australia, and the UK. They<br>continue to trust us to deploy end-to-end strategies tailored to their unique needs and goals.</h5>
        <div class=\"emb-row emb-wrap client-items\">
            ";
        // line 30
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["rows"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["row"]) {
            // line 31
            echo "            <div class=\"emb-col-md-6 emb-col-sm-12 emb-col-lg-3\">
                <div class=\"client-item\">
                    <div class=\"client-logo\">";
            // line 33
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["view"] ?? null), "style_plugin", [], "any", false, false, true, 33), "getField", [0 => $context["key"], 1 => "field_client_image"], "method", false, false, true, 33), 33, $this->source), "html", null, true);
            echo "</div>
                    <div class=\"client-content\">
                        <h4 class=\"client-name\">";
            // line 35
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["view"] ?? null), "style_plugin", [], "any", false, false, true, 35), "getField", [0 => $context["key"], 1 => "title"], "method", false, false, true, 35), 35, $this->source), "html", null, true);
            echo "</h4>
                        ";
            // line 36
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["view"] ?? null), "style_plugin", [], "any", false, false, true, 36), "getField", [0 => $context["key"], 1 => "body"], "method", false, false, true, 36), 36, $this->source), "html", null, true);
            echo "
                        <!-- <a target=\"_blank\" href=\"";
            // line 37
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_trim_filter(twig_striptags($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["view"] ?? null), "style_plugin", [], "any", false, false, true, 37), "getField", [0 => $context["key"], 1 => "field_website_link"], "method", false, false, true, 37), 37, $this->source))), "html", null, true);
            echo "\">Read more</a>-->

                    </div>
                </div>
\t\t\t    </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 43
        echo "        </div>
    </div>
</section>
";
    }

    public function getTemplateName()
    {
        return "themes/custom/embark/templates/views/views-view-unformatted--clients--homeclients.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 43,  70 => 37,  66 => 36,  62 => 35,  57 => 33,  53 => 31,  49 => 30,  42 => 25,  40 => 22,  39 => 21,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/embark/templates/views/views-view-unformatted--clients--homeclients.html.twig", "D:\\xampp-8.1.17\\htdocs\\embark\\themes\\custom\\embark\\templates\\views\\views-view-unformatted--clients--homeclients.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 21, "for" => 30);
        static $filters = array("escape" => 33, "trim" => 37, "striptags" => 37);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'for'],
                ['escape', 'trim', 'striptags'],
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
