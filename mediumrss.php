<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

class MediumRssPlugin extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
        ];
    }

    public function onTwigTemplatePaths(Event $event)
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    public function onTwigSiteVariables(Event $event)
    {
        $this->grav['twig']->twig_vars['fetchMediumRSS'] = $this->fetchMediumRSS();
    }

    private function fetchMediumRSS()
    {
        $response = file_get_contents($this->config->get('plugins.mediumrss.rss_feed_url'));
        $xml = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
        $items = $xml->channel->item;
        $output = '';

        foreach ($items as $item) {
            $title = (string) $item->title;
            $link = (string) $item->link;
            $description = (string) $item->description;
            $content = (string) $item->children('content', true)->encoded;

            // Überprüfen, ob der Inhalt nicht leer ist
            if (!empty($content)) {
                // Extrahiere den ersten Absatz des Inhalts
                preg_match('/<p>(.*?)<\/p>/', $content, $matches);
                $firstParagraph = $matches[1] ?? '';
            } else {
                $firstParagraph = '';
            }

            $output .= '<li style="text-decoration: none; list-style-type: none;">';
            $output .= '<a href="' . htmlspecialchars($link) . '" target="'.$this->config->get('plugins.mediumrss.target').'"><strong>' . htmlspecialchars($title) . '</strong></a><br>';
            $output .= htmlspecialchars($firstParagraph);
            $output .= '</li><br>';
        }

        return $output;
    }
}