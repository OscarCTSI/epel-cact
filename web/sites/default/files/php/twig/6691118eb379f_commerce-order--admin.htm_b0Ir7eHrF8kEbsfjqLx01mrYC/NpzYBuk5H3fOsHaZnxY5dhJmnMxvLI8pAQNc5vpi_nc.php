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

/* modules/contrib/commerce/modules/order/templates/commerce-order--admin.html.twig */
class __TwigTemplate_7896cc06dd18189b20afbeb16317f5d7 extends \Twig\Template
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
        // line 20
        echo "
";
        // line 21
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("commerce/form-layout"), "html", null, true);
        echo "
";
        // line 22
        $context["order_state"] = twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["order_entity"] ?? null), "getState", [], "any", false, false, true, 22), "getLabel", [], "any", false, false, true, 22);
        // line 23
        echo "
<div class=\"layout-order-form clearfix\">
  <div class=\"layout-region layout-region--commerce-main\">
    <div class=\"layout-region__content\">
      ";
        // line 27
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "order_items", [], "any", false, false, true, 27), 27, $this->source), "html", null, true);
        echo "
      ";
        // line 28
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "total_price", [], "any", false, false, true, 28), 28, $this->source), "html", null, true);
        echo "

      ";
        // line 30
        if (twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "activity", [], "any", false, false, true, 30)) {
            // line 31
            echo "        <h2>";
            echo t("Order activity", array());
            echo "</h2>
        ";
            // line 32
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "activity", [], "any", false, false, true, 32), 32, $this->source), "html", null, true);
            echo "
      ";
        }
        // line 34
        echo "    </div>
  </div>
  <div class=\"layout-region layout-region--commerce-secondary\">
    <div class=\"entity-meta\">
      <div class=\"entity-meta__header\">
        <h3 class=\"entity-meta__title\">
          ";
        // line 40
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["order_state"] ?? null), 40, $this->source), "html", null, true);
        echo "
        </h3>
        ";
        // line 42
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable([0 => "completed", 1 => "placed", 2 => "changed"]);
        foreach ($context['_seq'] as $context["_key"] => $context["key"]) {
            // line 43
            echo "          ";
            if ((($__internal_compile_0 = ($context["order"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[$context["key"]] ?? null) : null)) {
                // line 44
                echo "            <div class=\"form-item\">
              ";
                // line 45
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_1 = ($context["order"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1[$context["key"]] ?? null) : null), 45, $this->source), "html", null, true);
                echo "
            </div>
          ";
            }
            // line 48
            echo "        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['key'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 49
        echo "        ";
        if (((($context["stores_count"] ?? null) > 1) && twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "store_id", [], "any", false, false, true, 49))) {
            // line 50
            echo "          <div class=\"form-item\">
            ";
            // line 51
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "store_id", [], "any", false, false, true, 51), 51, $this->source), "html", null, true);
            echo "
          </div>
        ";
        }
        // line 54
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "balance", [], "any", false, false, true, 54)) {
            // line 55
            echo "          <div class=\"form-item\">
            ";
            // line 56
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "balance", [], "any", false, false, true, 56), 56, $this->source), "html", null, true);
            echo "
          </div>
        ";
        }
        // line 59
        echo "        ";
        // line 60
        echo "        ";
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["order_entity"] ?? null), "getState", [], "any", false, false, true, 60), "getTransitions", [], "any", false, false, true, 60))) {
            // line 61
            echo "          ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "state", [], "any", false, false, true, 61), 61, $this->source), "html", null, true);
            echo "
        ";
        }
        // line 63
        echo "      </div>
      <details open class=\"seven-details\">
        <summary role=\"button\" class=\"seven-details__summary\">
          ";
        // line 66
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Customer Information"));
        echo "
        </summary>
        <div class=\"details-wrapper seven-details__wrapper\">
          ";
        // line 69
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable([0 => "uid", 1 => "mail", 2 => "ip_address"]);
        foreach ($context['_seq'] as $context["_key"] => $context["key"]) {
            // line 70
            echo "            ";
            if ((($__internal_compile_2 = ($context["order"] ?? null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2[$context["key"]] ?? null) : null)) {
                // line 71
                echo "              <div class=\"form-item\">
                ";
                // line 72
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_3 = ($context["order"] ?? null)) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3[$context["key"]] ?? null) : null), 72, $this->source), "html", null, true);
                echo "
              </div>
            ";
            }
            // line 75
            echo "          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['key'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 76
        echo "        </div>
      </details>
      ";
        // line 78
        if (twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "billing_information", [], "any", false, false, true, 78)) {
            // line 79
            echo "        <details open class=\"seven-details\">
          <summary role=\"button\" class=\"seven-details__summary\">
            ";
            // line 81
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Billing information"));
            echo "
          </summary>
          <div class=\"details-wrapper seven-details__wrapper\">
            ";
            // line 84
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "billing_information", [], "any", false, false, true, 84), 84, $this->source), "html", null, true);
            echo "
          </div>
        </details>
      ";
        }
        // line 88
        echo "      ";
        if (twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "shipping_information", [], "any", false, false, true, 88)) {
            // line 89
            echo "        <details open class=\"seven-details\">
          <summary role=\"button\" class=\"seven-details__summary\">
            ";
            // line 91
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Shipping information"));
            echo "
          </summary>
          <div class=\"details-wrapper seven-details__wrapper\">
            ";
            // line 94
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "shipping_information", [], "any", false, false, true, 94), 94, $this->source), "html", null, true);
            echo "
          </div>
        </details>
      ";
        }
        // line 98
        echo "      ";
        if (($context["additional_order_fields"] ?? null)) {
            // line 99
            echo "        <details open class=\"seven-details\">
          <summary role=\"button\" class=\"seven-details__summary\">
            ";
            // line 101
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Other"));
            echo "
          </summary>
          ";
            // line 104
            echo "          <div class=\"details-wrapper seven-details__wrapper\">
            ";
            // line 105
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["additional_order_fields"] ?? null), 105, $this->source), "html", null, true);
            echo "
          </div>
        </details>
      ";
        }
        // line 109
        echo "    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/contrib/commerce/modules/order/templates/commerce-order--admin.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  243 => 109,  236 => 105,  233 => 104,  228 => 101,  224 => 99,  221 => 98,  214 => 94,  208 => 91,  204 => 89,  201 => 88,  194 => 84,  188 => 81,  184 => 79,  182 => 78,  178 => 76,  172 => 75,  166 => 72,  163 => 71,  160 => 70,  156 => 69,  150 => 66,  145 => 63,  139 => 61,  136 => 60,  134 => 59,  128 => 56,  125 => 55,  122 => 54,  116 => 51,  113 => 50,  110 => 49,  104 => 48,  98 => 45,  95 => 44,  92 => 43,  88 => 42,  83 => 40,  75 => 34,  70 => 32,  65 => 31,  63 => 30,  58 => 28,  54 => 27,  48 => 23,  46 => 22,  42 => 21,  39 => 20,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/commerce/modules/order/templates/commerce-order--admin.html.twig", "/usr/share/nginx/html/cacttest/web/modules/contrib/commerce/modules/order/templates/commerce-order--admin.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 22, "if" => 30, "trans" => 31, "for" => 42);
        static $filters = array("escape" => 21, "t" => 66);
        static $functions = array("attach_library" => 21);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'trans', 'for'],
                ['escape', 't'],
                ['attach_library'],
                $this->source
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
