<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate sitemap XML on each request (public pages + approved agents).
     */
    public function index(): Response
    {
        $urls = [];

        $static = [
            ['route' => 'home', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['route' => 'ai-workforce', 'priority' => '0.85', 'changefreq' => 'weekly'],
            ['route' => 'agents.explore', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['route' => 'contact', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['route' => 'privacy-policy', 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['route' => 'terms-of-service', 'priority' => '0.5', 'changefreq' => 'yearly'],
        ];

        foreach ($static as $item) {
            $urls[] = [
                'loc' => route($item['route']),
                'lastmod' => now()->toAtomString(),
                'changefreq' => $item['changefreq'],
                'priority' => $item['priority'],
            ];
        }

        Agent::query()
            ->where('is_approved', true)
            ->orderBy('id')
            ->select(['id', 'updated_at'])
            ->chunkById(500, function ($agents) use (&$urls) {
                foreach ($agents as $agent) {
                    $urls[] = [
                        'loc' => route('agents.show', $agent),
                        'lastmod' => $agent->updated_at?->toAtomString() ?? now()->toAtomString(),
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                    ];
                }
            });

        $xml = $this->buildXml($urls);

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * @param  array<int, array{loc: string, lastmod: string, changefreq: string, priority: string}>  $urls
     */
    private function buildXml(array $urls): string
    {
        $lines = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
        ];

        foreach ($urls as $u) {
            $lines[] = '  <url>';
            $lines[] = '    <loc>'.htmlspecialchars($u['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8').'</loc>';
            $lines[] = '    <lastmod>'.htmlspecialchars($u['lastmod'], ENT_XML1 | ENT_QUOTES, 'UTF-8').'</lastmod>';
            $lines[] = '    <changefreq>'.htmlspecialchars($u['changefreq'], ENT_XML1 | ENT_QUOTES, 'UTF-8').'</changefreq>';
            $lines[] = '    <priority>'.htmlspecialchars($u['priority'], ENT_XML1 | ENT_QUOTES, 'UTF-8').'</priority>';
            $lines[] = '  </url>';
        }

        $lines[] = '</urlset>';

        return implode("\n", $lines);
    }
}
