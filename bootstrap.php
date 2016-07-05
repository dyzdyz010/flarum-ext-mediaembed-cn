<?php

use Flarum\Event\ConfigureFormatter;
use Illuminate\Events\Dispatcher;
use s9e\TextFormatter\Configurator\Bundles\MediaPack;

function subscribe(Dispatcher $events)
{
    $events->listen(
        ConfigureFormatter::class,
        function (ConfigureFormatter $event)
        {
            $event->configurator->MediaEmbed->add(
                'bilibili',
                [
                    'host'    => 'www.bilibili.com',
                    'extract' => "!www.bilibili.com/video/av(?'id'[0-9]+)/!",
                    'flash'  => [
                        'width'  => 544,
                        'height' => 415,
                        'src'    => 'https://static-s.bilibili.com/miniloader.swf?aid={@id}'
                    ]
                ]
            );

            $event->configurator->MediaEmbed->add(
                'music163',
                [
                    'host'    => 'music.163.com',
                    'extract' => "!music\\.163\\.com/#/song\\?id=(?'id'\\d+)!",
                    'iframe'  => [
                        'width'  => 330,
                        'height' => 86,
                        'frameborder' => 'no',
                        'border' => '0',
                        'marginwidth' => '0',
                        'marginheight' => '0',
                        'src'    => 'http://music.163.com/outchain/player?type=2&id={@id}&auto=0&height=66'
                    ]
                ]
            );

            $event->configurator->MediaEmbed->add(
                'applemusicplaylist',
                [
                    'host'    => 'itunes.apple.com',
                    'extract' => "!itunes\\.apple\\.com/(?'country'[a-z]+)/playlist/[a-z-a-z]+/idpl.(?'id'[0-9a-z]+)!",
                    'iframe'  => [
                        'width'  => '100%',
                        'height' => 500,
                        'src'    => 'https://playlists.applemusic.com/embed/pl.{@id}?country={@country}&app=music'
                    ]
                ]
            );
            (new MediaPack)->configure($event->configurator);
        }
    );
};

return __NAMESPACE__ . '\\subscribe';