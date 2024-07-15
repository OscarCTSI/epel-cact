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

/* modules/custom/cact_general/templates/order-item-products-info-partial-mail.html.twig */
class __TwigTemplate_06817e9821e2d46236d31c13635a11ec extends \Twig\Template
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
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["products_info"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["product_info"]) {
            // line 2
            echo "  <p style=\"font-size: 11pt; font-variant: normal; font-family: Arial; font-weight: 400; font-style: normal; text-decoration: none;\">
    ";
            // line 3
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["product_info"], "product_name", [], "any", false, false, true, 3), 3, $this->source), "html", null, true);
            echo "
    ";
            // line 4
            if (twig_get_attribute($this->env, $this->source, $context["product_info"], "reference_openbravo", [], "any", false, false, true, 4)) {
                // line 5
                echo "      ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("(QR único)"));
                echo "
      <a href=\"";
                // line 6
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["product_info"], "path", [], "any", false, false, true, 6), 6, $this->source), "html", null, true);
                echo "\">
        🎫 ";
                // line 7
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Descargar tickets"));
                echo " (PDF)
      </a>
    ";
            }
            // line 9
            echo "<br />
    ";
            // line 10
            if (twig_get_attribute($this->env, $this->source, $context["product_info"], "date", [], "any", false, false, true, 10)) {
                // line 11
                echo "      ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Fecha y hora"));
                echo ": ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["product_info"], "date", [], "any", false, false, true, 11), 11, $this->source), "html", null, true);
                echo "h <br />
    ";
            }
            // line 13
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Total"));
            echo ": ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["product_info"], "total_amount", [], "any", false, false, true, 13), 13, $this->source), "html", null, true);
            echo " €
  </p>

  ";
            // line 16
            if ( !twig_get_attribute($this->env, $this->source, $context["product_info"], "reference_openbravo", [], "any", false, false, true, 16)) {
                // line 17
                echo "    <p style=\"font-size: 11pt; font-variant: normal; font-family: Arial; font-weight: 400; font-style: normal; text-decoration: none;\">
      ";
                // line 18
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Download tickets"));
                echo "
    </p>
  ";
            } else {
                // line 21
                echo "    <p style=\"font-size: 11pt; font-variant: normal; font-family: Arial; font-weight: 400; font-style: normal; text-decoration: none;\">
      ";
                // line 22
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Detalles"));
                echo "
    </p>
  ";
            }
            // line 25
            echo "  <ol>
    ";
            // line 26
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["product_info"], "tickets", [], "any", false, false, true, 26));
            foreach ($context['_seq'] as $context["_key"] => $context["ticket"]) {
                // line 27
                echo "      <li>
        <span class=\"ticket-product-name\" style=\"font-size: 11pt; font-variant: normal; font-family: Arial; font-weight: 400; font-style: normal; text-decoration: none;\">
          ";
                // line 29
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["ticket"], "product_name", [], "any", false, false, true, 29), 29, $this->source), "html", null, true);
                echo "
        </span>
        <span class=\"ticket-ticket-type\" style=\"font-size: 11pt; font-variant: normal; font-family: Arial; font-weight: 400; font-style: normal; text-decoration: none;\">
          ";
                // line 32
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["ticket"], "name", [], "any", false, false, true, 32), 32, $this->source), "html", null, true);
                echo "
        </span>

        <span style=\"font-size: 11pt; font-variant: normal; font-family: Arial; font-weight: 400; font-style: normal; text-decoration: none;\">
        - ";
                // line 36
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Locator"));
                echo ": ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["ticket"], "location", [], "any", false, false, true, 36), 36, $this->source), "html", null, true);
                echo " (";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["ticket"], "price", [], "any", false, false, true, 36), 36, $this->source), "html", null, true);
                echo ")
        </span>
        ";
                // line 38
                if ( !twig_get_attribute($this->env, $this->source, $context["product_info"], "reference_openbravo", [], "any", false, false, true, 38)) {
                    // line 39
                    echo "          <br />
          <a href=\"";
                    // line 40
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["ticket"], "path", [], "any", false, false, true, 40), 40, $this->source), "html", null, true);
                    echo "\" style=\"font-size: 11pt; font-variant: normal; font-family: Arial; font-weight: 400; font-style: normal; text-decoration: none;\">
            🎫 ";
                    // line 41
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Descargar ticket"));
                    echo " (PDF)
          </a>
          <!--
          <a href=\"";
                    // line 44
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["ticket"], "path", [], "any", false, false, true, 44), 44, $this->source), "html", null, true);
                    echo "\">
            🎫 Descargar Ticket (Passbook)
          </a>
          -->
        ";
                }
                // line 49
                echo "      </li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ticket'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 51
            echo "  </ol>
  ";
            // line 52
            if (twig_get_attribute($this->env, $this->source, $context["product_info"], "calendar", [], "any", false, false, true, 52)) {
                // line 53
                echo "    <a href=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["product_info"], "calendar", [], "any", false, false, true, 53), 53, $this->source), "html", null, true);
                echo "\" style=\"font-size: 11pt; font-variant: normal; font-family: Arial; font-weight: 400; font-style: normal; text-decoration: none;\">
      Añadir a Google Calendar
    </a><br />
  ";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['product_info'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "modules/custom/cact_general/templates/order-item-products-info-partial-mail.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  177 => 53,  175 => 52,  172 => 51,  165 => 49,  157 => 44,  151 => 41,  147 => 40,  144 => 39,  142 => 38,  133 => 36,  126 => 32,  120 => 29,  116 => 27,  112 => 26,  109 => 25,  103 => 22,  100 => 21,  94 => 18,  91 => 17,  89 => 16,  80 => 13,  72 => 11,  70 => 10,  67 => 9,  61 => 7,  57 => 6,  52 => 5,  50 => 4,  46 => 3,  43 => 2,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/cact_general/templates/order-item-products-info-partial-mail.html.twig", "/usr/share/nginx/html/cacttest/web/modules/custom/cact_general/templates/order-item-products-info-partial-mail.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 1, "if" => 4);
        static $filters = array("escape" => 3, "trans" => 5);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for', 'if'],
                ['escape', 'trans'],
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
