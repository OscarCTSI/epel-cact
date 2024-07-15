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

/* themes/custom/cact/templates/layout/page.html.twig */
class __TwigTemplate_7282f9adcbaa1ca2f8e0ffabc3ad2148 extends \Twig\Template
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
        // line 48
        echo "<div class=\"layout-container\">


  <header aria-label=\"";
        // line 51
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Site header"));
        echo "\">

    ";
        // line 53
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "top_bar", [], "any", false, false, true, 53)) {
            // line 54
            echo "      <div class=\"top-bar\">
        ";
            // line 55
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "top_bar", [], "any", false, false, true, 55), 55, $this->source), "html", null, true);
            echo "
      </div>
    ";
        }
        // line 58
        echo "
    <div class=\"wrapper-header\">

      <div class=\"site-header\">
        ";
        // line 62
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "cact_branding"), "html", null, true);
        echo "

        <div class=\"site-header-desktop\">
          ";
        // line 65
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "navegacionprincipal"), "html", null, true);
        echo "
          ";
        // line 66
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "entradashomeheader"), "html", null, true);
        echo "
          ";
        // line 67
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "cart"), "html", null, true);
        echo "
          <div class=\"menu-idioma\">
            <h2 class=\"idioma-expand\">Languaje</h2>
            <span class=\"arrow\"></span>
            ";
        // line 71
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "alternadordeidioma"), "html", null, true);
        echo "
          </div>
        </div>
        <div class=\"site-header-mobile\">
          ";
        // line 75
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "cart"), "html", null, true);
        echo "
          <div class=\"col s3 menu-clk\">
            <div class=\"menu-icon\">
              <button id=\"click-menu\" class=\"btn-empty\">
                <div class=\"menunav--burguer main--menu \" >
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class=\"menu-links-mobile\">
      ";
        // line 91
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "navegacionprincipal"), "html", null, true);
        echo "
      ";
        // line 92
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "entradashomeheader"), "html", null, true);
        echo "
      <div class=\"menu-idioma\">
        <h2 class=\"idoma-expand\">Languaje</h2>
        <span class=\"arrow\"></span>
        ";
        // line 96
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "alternadordeidioma"), "html", null, true);
        echo "
      </div>
    </div>
  </header>

  ";
        // line 101
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 101)) {
            // line 102
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 102), 102, $this->source), "html", null, true);
            echo "
  ";
        }
        // line 104
        echo "
  ";
        // line 105
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 105)) {
            // line 106
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 106), 106, $this->source), "html", null, true);
            echo "
  ";
        }
        // line 108
        echo "
  ";
        // line 109
        if ($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 109))) {
            // line 110
            echo "  <div class=\"site-breadcrumb\">
    ";
            // line 111
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 111), 111, $this->source), "html", null, true);
            echo "
  </div>
  ";
        }
        // line 114
        echo "
  ";
        // line 115
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured_top", [], "any", false, false, true, 115)) {
            // line 116
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured_top", [], "any", false, false, true, 116), 116, $this->source), "html", null, true);
            echo "
  ";
        }
        // line 118
        echo "
  ";
        // line 119
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "help", [], "any", false, false, true, 119)) {
            // line 120
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "help", [], "any", false, false, true, 120), 120, $this->source), "html", null, true);
            echo "
  ";
        }
        // line 122
        echo "
  <main>
    <a id=\"main-content\" tabindex=\"-1\"></a>";
        // line 125
        echo "
    <div class=\"layout-wrapper\">

      <div class=\"layout-content\">
        ";
        // line 129
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 129), 129, $this->source), "html", null, true);
        echo "
      </div>";
        // line 131
        echo "
      ";
        // line 132
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 132)) {
            // line 133
            echo "      <aside class=\"layout-sidebar-first\">
        ";
            // line 134
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 134), 134, $this->source), "html", null, true);
            echo "
      </aside>
      ";
        }
        // line 137
        echo "
      ";
        // line 138
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 138)) {
            // line 139
            echo "      <aside class=\"layout-sidebar-second\">
        ";
            // line 140
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 140), 140, $this->source), "html", null, true);
            echo "
      </aside>
      ";
        }
        // line 143
        echo "
    </div>
  </main>

  ";
        // line 147
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content_bottom", [], "any", false, false, true, 147)) {
            // line 148
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content_bottom", [], "any", false, false, true, 148), 148, $this->source), "html", null, true);
            echo "
  ";
        }
        // line 150
        echo "
  ";
        // line 151
        if ((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 151) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_info", [], "any", false, false, true, 151))) {
            // line 152
            echo "  <footer class=\"site-footer\">

    ";
            // line 154
            if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 154)) {
                // line 155
                echo "    <div class=\"footer-wrapper\">
      ";
                // line 156
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 156), 156, $this->source), "html", null, true);
                echo "
    </div>
    ";
            }
            // line 159
            echo "
    ";
            // line 160
            if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_info", [], "any", false, false, true, 160)) {
                // line 161
                echo "    <div class=\"footer-info-wrapper\">
      ";
                // line 163
                echo "      <div class=\"footer-info\">
        <div class=\"wrapper-logo-copyright\">
          ";
                // line 165
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "logofooter"), "html", null, true);
                echo "
          ";
                // line 166
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "copyright"), "html", null, true);
                echo "
        </div>
        <div class=\"wrapper-newsletter-social\">
          ";
                // line 169
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "simplenewssubscription"), "html", null, true);
                echo "
          ";
                // line 170
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "socialmedialinks"), "html", null, true);
                echo "
        </div>
        <div class=\"wrapper-main-menu-footer\">
          <div class=\"main-menu-footer\">
            ";
                // line 174
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalMenu("footer"), "html", null, true);
                echo " 
          </div>
        </div>
        <div class=\"wrapper-legal-menu-footer\">
          <div class=\"legal-menu\">
            ";
                // line 179
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalMenu("legal"), "html", null, true);
                echo "
          </div>
        </div>
        <div class=\"copyright-mobile\">
           ";
                // line 183
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::drupalEntity("block", "copyright"), "html", null, true);
                echo "
        </div>
      </div>
    </div>
    ";
            }
            // line 188
            echo "
  </footer>
  ";
        }
        // line 191
        echo "
";
        // line 192
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "convert", [], "any", false, false, true, 192), 192, $this->source), "html", null, true);
        echo "
</div>";
    }

    public function getTemplateName()
    {
        return "themes/custom/cact/templates/layout/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  327 => 192,  324 => 191,  319 => 188,  311 => 183,  304 => 179,  296 => 174,  289 => 170,  285 => 169,  279 => 166,  275 => 165,  271 => 163,  268 => 161,  266 => 160,  263 => 159,  257 => 156,  254 => 155,  252 => 154,  248 => 152,  246 => 151,  243 => 150,  237 => 148,  235 => 147,  229 => 143,  223 => 140,  220 => 139,  218 => 138,  215 => 137,  209 => 134,  206 => 133,  204 => 132,  201 => 131,  197 => 129,  191 => 125,  187 => 122,  181 => 120,  179 => 119,  176 => 118,  170 => 116,  168 => 115,  165 => 114,  159 => 111,  156 => 110,  154 => 109,  151 => 108,  145 => 106,  143 => 105,  140 => 104,  134 => 102,  132 => 101,  124 => 96,  117 => 92,  113 => 91,  94 => 75,  87 => 71,  80 => 67,  76 => 66,  72 => 65,  66 => 62,  60 => 58,  54 => 55,  51 => 54,  49 => 53,  44 => 51,  39 => 48,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/cact/templates/layout/page.html.twig", "/usr/share/nginx/html/ventaonline/web/themes/custom/cact/templates/layout/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 53);
        static $filters = array("t" => 51, "escape" => 55, "render" => 109);
        static $functions = array("drupal_entity" => 62, "drupal_menu" => 174);

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['t', 'escape', 'render'],
                ['drupal_entity', 'drupal_menu']
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
