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

/* modules/contrib/address/templates/address-plain.html.twig */
class __TwigTemplate_a2822c5299a35acb8806be1e95e2c2de extends \Twig\Template
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
        // line 39
        echo "<p class=\"address\" translate=\"no\">
  ";
        // line 40
        if ((($context["given_name"] ?? null) || ($context["family_name"] ?? null))) {
            // line 41
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["given_name"] ?? null), 41, $this->source), "html", null, true);
            echo " ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["family_name"] ?? null), 41, $this->source), "html", null, true);
            echo " <br>
  ";
        }
        // line 43
        echo "  ";
        if (($context["organization"] ?? null)) {
            // line 44
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["organization"] ?? null), 44, $this->source), "html", null, true);
            echo " <br>
  ";
        }
        // line 46
        echo "  ";
        if (($context["address_line1"] ?? null)) {
            // line 47
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["address_line1"] ?? null), 47, $this->source), "html", null, true);
            echo " <br>
  ";
        }
        // line 49
        echo "  ";
        if (($context["address_line2"] ?? null)) {
            // line 50
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["address_line2"] ?? null), 50, $this->source), "html", null, true);
            echo " <br>
  ";
        }
        // line 52
        echo "  ";
        if (twig_get_attribute($this->env, $this->source, ($context["dependent_locality"] ?? null), "code", [], "any", false, false, true, 52)) {
            // line 53
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["dependent_locality"] ?? null), "code", [], "any", false, false, true, 53), 53, $this->source), "html", null, true);
            echo " <br>
  ";
        }
        // line 55
        echo "  ";
        if (((twig_get_attribute($this->env, $this->source, ($context["locality"] ?? null), "code", [], "any", false, false, true, 55) || ($context["postal_code"] ?? null)) || twig_get_attribute($this->env, $this->source, ($context["administrative_area"] ?? null), "code", [], "any", false, false, true, 55))) {
            // line 56
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["locality"] ?? null), "code", [], "any", false, false, true, 56), 56, $this->source), "html", null, true);
            echo " ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["postal_code"] ?? null), 56, $this->source), "html", null, true);
            echo " ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["administrative_area"] ?? null), "code", [], "any", false, false, true, 56), 56, $this->source), "html", null, true);
            echo " <br>
  ";
        }
        // line 58
        echo "  ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["country"] ?? null), "name", [], "any", false, false, true, 58), 58, $this->source), "html", null, true);
        echo "
</p>
";
    }

    public function getTemplateName()
    {
        return "modules/contrib/address/templates/address-plain.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  101 => 58,  91 => 56,  88 => 55,  82 => 53,  79 => 52,  73 => 50,  70 => 49,  64 => 47,  61 => 46,  55 => 44,  52 => 43,  44 => 41,  42 => 40,  39 => 39,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/address/templates/address-plain.html.twig", "/usr/share/nginx/html/cacttest/web/modules/contrib/address/templates/address-plain.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 40);
        static $filters = array("escape" => 41);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
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
