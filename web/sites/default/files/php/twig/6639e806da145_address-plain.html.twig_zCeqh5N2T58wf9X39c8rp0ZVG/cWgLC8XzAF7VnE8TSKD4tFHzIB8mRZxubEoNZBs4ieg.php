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

/* themes/custom/cact/templates/address-plain.html.twig */
class __TwigTemplate_13e9f3eadcc76f561838214aa658c607 extends \Twig\Template
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
            echo "  <span class=\"fullname\" style=\"display: block;\" >
    ";
            // line 42
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["given_name"] ?? null), 42, $this->source), "html", null, true);
            echo " ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["family_name"] ?? null), 42, $this->source), "html", null, true);
            echo " 
  </span>
  ";
        }
        // line 45
        echo "    ";
        if (($context["organization"] ?? null)) {
            // line 46
            echo "    <span class=\"organization-review\" style=\"display: block;\" >
      ";
            // line 47
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["organization"] ?? null), 47, $this->source), "html", null, true);
            echo " 
    </span>
    ";
        }
        // line 50
        echo " 
  <span class=\"fulladdress\" style=\"display: block;\" >
    ";
        // line 52
        if (($context["address_line1"] ?? null)) {
            // line 53
            echo "      ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["address_line1"] ?? null), 53, $this->source), "html", null, true);
            echo "
    ";
        }
        // line 55
        echo "    ";
        if (($context["address_line2"] ?? null)) {
            // line 56
            echo "      ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["address_line2"] ?? null), 56, $this->source), "html", null, true);
            echo "
    ";
        }
        // line 58
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, ($context["dependent_locality"] ?? null), "code", [], "any", false, false, true, 58)) {
            // line 59
            echo "      ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["dependent_locality"] ?? null), "code", [], "any", false, false, true, 59), 59, $this->source), "html", null, true);
            echo "
    ";
        }
        // line 61
        echo "    ";
        if (((twig_get_attribute($this->env, $this->source, ($context["locality"] ?? null), "code", [], "any", false, false, true, 61) || ($context["postal_code"] ?? null)) || twig_get_attribute($this->env, $this->source, ($context["administrative_area"] ?? null), "code", [], "any", false, false, true, 61))) {
            // line 62
            echo "      ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["locality"] ?? null), "code", [], "any", false, false, true, 62), 62, $this->source), "html", null, true);
            echo " ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["postal_code"] ?? null), 62, $this->source), "html", null, true);
            echo " ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["administrative_area"] ?? null), "code", [], "any", false, false, true, 62), 62, $this->source), "html", null, true);
            echo "
    ";
        }
        // line 64
        echo "    ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["country"] ?? null), "name", [], "any", false, false, true, 64), 64, $this->source), "html", null, true);
        echo "
  </span>
</p>
";
    }

    public function getTemplateName()
    {
        return "themes/custom/cact/templates/address-plain.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  110 => 64,  100 => 62,  97 => 61,  91 => 59,  88 => 58,  82 => 56,  79 => 55,  73 => 53,  71 => 52,  67 => 50,  61 => 47,  58 => 46,  55 => 45,  47 => 42,  44 => 41,  42 => 40,  39 => 39,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/cact/templates/address-plain.html.twig", "/usr/share/nginx/html/cacttest/web/themes/custom/cact/templates/address-plain.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 40);
        static $filters = array("escape" => 42);
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
