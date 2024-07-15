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
class __TwigTemplate_f9638fe15538ee863f78dbda35ed83bc extends \Twig\Template
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
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("commerce_order/form"), "html", null, true);
        echo "
";
        // line 22
        $context["order_state"] = twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["order_entity"] ?? null), "getState", [], "any", false, false, true, 22), "getLabel", [], "any", false, false, true, 22);
        // line 23
        echo "
<div class=\"layout-order-form clearfix\">
  <div class=\"layout-region layout-region-order-main\">
    ";
        // line 26
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "order_items", [], "any", false, false, true, 26), 26, $this->source), "html", null, true);
        echo "
    ";
        // line 27
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "total_price", [], "any", false, false, true, 27), 27, $this->source), "html", null, true);
        echo "

    ";
        // line 29
        if (twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "activity", [], "any", false, false, true, 29)) {
            // line 30
            echo "      <h2>";
            echo t("Order activity", array());
            echo "</h2>
      ";
            // line 31
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "activity", [], "any", false, false, true, 31), 31, $this->source), "html", null, true);
            echo "
    ";
        }
        // line 33
        echo "  </div>
  <div class=\"layout-region layout-region-order-secondary\">
    <div class=\"entity-meta\">
      <div class=\"entity-meta__header\">
        <h3 class=\"entity-meta__title\">
          ";
        // line 38
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["order_state"] ?? null), 38, $this->source), "html", null, true);
        echo "
        </h3>
        ";
        // line 40
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable([0 => "completed", 1 => "placed", 2 => "changed"]);
        foreach ($context['_seq'] as $context["_key"] => $context["key"]) {
            // line 41
            echo "          ";
            if ((($__internal_compile_0 = ($context["order"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[$context["key"]] ?? null) : null)) {
                // line 42
                echo "            <div class=\"form-item\">
              ";
                // line 43
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_1 = ($context["order"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1[$context["key"]] ?? null) : null), 43, $this->source), "html", null, true);
                echo "
            </div>
          ";
            }
            // line 46
            echo "        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['key'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "balance", [], "any", false, false, true, 47)) {
            // line 48
            echo "          <div class=\"form-item\">
            ";
            // line 49
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "balance", [], "any", false, false, true, 49), 49, $this->source), "html", null, true);
            echo "
          </div>
        ";
        }
        // line 52
        echo "        ";
        // line 53
        echo "        ";
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["order_entity"] ?? null), "getState", [], "any", false, false, true, 53), "getTransitions", [], "any", false, false, true, 53))) {
            // line 54
            echo "          ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "state", [], "any", false, false, true, 54), 54, $this->source), "html", null, true);
            echo "
        ";
        }
        // line 56
        echo "      </div>
      <details open class=\"seven-details\">
        <summary role=\"button\" class=\"seven-details__summary\">
          ";
        // line 59
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Customer Information"));
        echo "
        </summary>
        <div class=\"details-wrapper seven-details__wrapper\">
          ";
        // line 62
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable([0 => "uid", 1 => "mail", 2 => "ip_address"]);
        foreach ($context['_seq'] as $context["_key"] => $context["key"]) {
            // line 63
            echo "            ";
            if ((($__internal_compile_2 = ($context["order"] ?? null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2[$context["key"]] ?? null) : null)) {
                // line 64
                echo "              <div class=\"form-item\">
                ";
                // line 65
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_3 = ($context["order"] ?? null)) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3[$context["key"]] ?? null) : null), 65, $this->source), "html", null, true);
                echo "
              </div>
            ";
            }
            // line 68
            echo "          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['key'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 69
        echo "        </div>
      </details>
      ";
        // line 71
        if (twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "billing_information", [], "any", false, false, true, 71)) {
            // line 72
            echo "        <details open class=\"seven-details\">
          <summary role=\"button\" class=\"seven-details__summary\">
            ";
            // line 74
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Billing information"));
            echo "
          </summary>
          <div class=\"details-wrapper seven-details__wrapper\">
            ";
            // line 77
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "billing_information", [], "any", false, false, true, 77), 77, $this->source), "html", null, true);
            echo "
          </div>
        </details>
      ";
        }
        // line 81
        echo "      ";
        if (twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "shipping_information", [], "any", false, false, true, 81)) {
            // line 82
            echo "        <details open class=\"seven-details\">
          <summary role=\"button\" class=\"seven-details__summary\">
            ";
            // line 84
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Shipping information"));
            echo "
          </summary>
          <div class=\"details-wrapper seven-details__wrapper\">
            ";
            // line 87
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["order"] ?? null), "shipping_information", [], "any", false, false, true, 87), 87, $this->source), "html", null, true);
            echo "
          </div>
        </details>
      ";
        }
        // line 91
        echo "      ";
        if (($context["additional_order_fields"] ?? null)) {
            // line 92
            echo "        <details open class=\"seven-details\">
          <summary role=\"button\" class=\"seven-details__summary\">
            ";
            // line 94
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Other"));
            echo "
          </summary>
          ";
            // line 97
            echo "          <div class=\"details-wrapper seven-details__wrapper\">
            ";
            // line 98
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["additional_order_fields"] ?? null), 98, $this->source), "html", null, true);
            echo "
          </div>
        </details>
      ";
        }
        // line 102
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
        return array (  229 => 102,  222 => 98,  219 => 97,  214 => 94,  210 => 92,  207 => 91,  200 => 87,  194 => 84,  190 => 82,  187 => 81,  180 => 77,  174 => 74,  170 => 72,  168 => 71,  164 => 69,  158 => 68,  152 => 65,  149 => 64,  146 => 63,  142 => 62,  136 => 59,  131 => 56,  125 => 54,  122 => 53,  120 => 52,  114 => 49,  111 => 48,  108 => 47,  102 => 46,  96 => 43,  93 => 42,  90 => 41,  86 => 40,  81 => 38,  74 => 33,  69 => 31,  64 => 30,  62 => 29,  57 => 27,  53 => 26,  48 => 23,  46 => 22,  42 => 21,  39 => 20,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/commerce/modules/order/templates/commerce-order--admin.html.twig", "/usr/share/nginx/html/cacttest/web/modules/contrib/commerce/modules/order/templates/commerce-order--admin.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 22, "if" => 29, "trans" => 30, "for" => 40);
        static $filters = array("escape" => 21, "t" => 59);
        static $functions = array("attach_library" => 21);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'trans', 'for'],
                ['escape', 't'],
                ['attach_library']
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
