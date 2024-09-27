<?php

$menu = [
	[
		"title" => "Главная",
		"href" => "/",
		"color" => "red"
	],
	[
		"title" => "Каталог",
		"href" => "/catalog/",
		"subitems" => [
			[
				"title" => "Автомобили",
				"href" => "/catalog/goods/"
			],
			[
				"title" => "Самолоеты",
				"href" => "/catalog/goods/",
				"subitems" => [
						[
							"title" => "Военные",
							"href" => "/catalog/goods/"
						],
						[
							"title" => "Гражданские",
							"href" => "/catalog/goods/"
						]
					]
			]
		]
	],
	[
		"title" => "Корабли",
		"href" => "/catalog/goods/"
	],
];


function getMenu($menuArray)
{
    $output = "<ul>";

    foreach ($menuArray as $item) {
        $output .= "<li><a href=\"{$item["href"]}\">{$item["title"]}</a>";
        if (isset($item["subitems"])) {
            $output .= getMenu($item["subitems"]);
        }
        $output .= "</li>";
    }
    $output .= "</ul>";
    return $output;
}



echo getMenu($menu);
