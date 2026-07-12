<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kazusa Meting API</title>
    <link rel="shortcut icon" href="https://www.raana.icu/images/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.1.4/tailwind.min.css" />
    <style>
        @font-face {
            font-family: "ZSFT-443";
            src: url("https://fontsapi.zeoseven.com/443/italic.woff2") format("woff2");
            font-style: italic;
            font-weight: 100 900;
            font-display: swap;
        }
        @font-face {
            font-family: "ZSFT-443";
            src: url("https://fontsapi.zeoseven.com/443/main.woff2") format("woff2");
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
        }
        body {
            font-family: "ZSFT-443", sans-serif;
            font-weight: normal;
        }
        strong, b, .font-bold {
            font-weight: 700;
        }
        code {
            font-family: monospace;
        }
    </style>
</head>

<body class="bg-gray-300 w-screen min-h-screen flex items-center justify-center py-10">
    <div class="max-w-4xl w-full mx-6">

        <!-- 标题 -->
        <div class="text-5xl font-bold text-gray-800 flex items-center flex-wrap gap-4">
            🎵 Meting-API 🎵
        </div>

        <!-- 描述 -->
        <p class="text-xl my-8 text-gray-800 leading-relaxed">
            基于 <strong class="text-pink-700">Meting</strong> 构建的音乐数据 API，
            由 <a href="https://www.raana.icu" target="_blank" class="text-pink-700 hover:underline">Kazusa1085</a> 提供服务，
            部署于 <a href="https://vercel.com" target="_blank" class="text-pink-700 hover:underline">Vercel</a>。
        </p>

        <!-- 参数说明 -->
        <div class="my-8">
            <h2 class="text-xl font-bold mb-4">📋 参数说明</h2>
            <ul class="list-disc ml-6 space-y-4 text-base">
                <!-- server -->
                <li>
                    <span class="bg-pink-600 rounded text-white px-2 py-0.5 font-bold">server</span>
                    <span class="ml-2 font-medium">数据源</span>
                    <ul class="list-circle ml-6 mt-1 text-gray-700 space-y-0.5">
                        <li><span class="font-bold">netease</span>（默认）网易云音乐</li>
                        <li><span class="font-bold">tencent</span> QQ音乐</li>
                    </ul>
                </li>
                <!-- type -->
                <li>
                    <span class="bg-pink-600 rounded text-white px-2 py-0.5 font-bold">type</span>
                    <span class="ml-2 font-medium">请求类型</span>
                    <ul class="list-circle ml-6 mt-1 text-gray-700 grid grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-0.5">
                        <li><span class="font-bold">name</span> 歌曲名</li>
                        <li><span class="font-bold">artist</span> 歌手</li>
                        <li><span class="font-bold">url</span> 链接</li>
                        <li><span class="font-bold">pic</span> 封面</li>
                        <li><span class="font-bold">lrc</span> 歌词</li>
                        <li><span class="font-bold">song</span> 单曲</li>
                        <li class="col-span-2 md:col-span-3"><span class="font-bold">playlist</span> 歌单</li>
                    </ul>
                </li>
                <!-- id -->
                <li>
                    <span class="bg-pink-600 rounded text-white px-2 py-0.5 font-bold">id</span>
                    <span class="ml-2 font-medium">类型ID</span>
                    <div class="ml-6 mt-1 text-gray-700">封面ID / 单曲ID / 歌单ID</div>
                </li>
            </ul>
        </div>

        <!-- 使用示例 -->
        <div class="my-8">
            <h2 class="text-xl font-bold mb-4">🚀 使用示例</h2>
            <ul class="list-decimal ml-6 space-y-3 text-base">
                <li>
                    <span class="bg-pink-600 rounded text-white px-2 py-0.5 text-sm">url</span>
                    <a href="<?php echo API_URI ?>?type=url&id=416892104"
                       target="_blank"
                       class="text-pink-700 hover:underline ml-2 break-all">
                        <?php echo API_URI ?>?type=url&id=416892104
                    </a>
                </li>
                <li>
                    <span class="bg-pink-600 rounded text-white px-2 py-0.5 text-sm">song</span>
                    <a href="<?php echo API_URI ?>?type=song&id=591321"
                       target="_blank"
                       class="text-pink-700 hover:underline ml-2 break-all">
                        <?php echo API_URI ?>?type=song&id=591321
                    </a>
                </li>
                <li>
                    <span class="bg-pink-600 rounded text-white px-2 py-0.5 text-sm">playlist</span>
                    <a href="<?php echo API_URI ?>?type=playlist&id=2619366284"
                       target="_blank"
                       class="text-pink-700 hover:underline ml-2 break-all">
                        <?php echo API_URI ?>?type=playlist&id=2619366284
                    </a>
                </li>
            </ul>
        </div>

        <!-- 底部链接 -->
        <div class="mt-10 pt-4 border-t border-gray-400 text-sm text-gray-700 flex flex-wrap items-center gap-x-3 gap-y-2">
            <span>📦 项目地址：</span>
            <a href="https://github.com/jinghuashang/vercel-meting-api" target="_blank"
               class="bg-pink-600 hover:bg-pink-700 text-white px-3 py-1 rounded transition-colors">
                jinghuashang/vercel-meting-api
            </a>
            <span class="text-gray-500">|</span>
            <span>🔗 基于</span>
            <a href="https://github.com/metowolf/Meting" target="_blank"
               class="bg-pink-600 hover:bg-pink-700 text-white px-3 py-1 rounded transition-colors">
                Meting
            </a>
        </div>

    </div>
</body>

</html><!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="shortcut icon" href="favicon.png">
    <title>Meting-API</title>
</head>

<body>
    <h2>参数说明</h2>
    server: 数据源
    <br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;netease 网易云音乐(默认)<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tencent QQ音乐<br />
    <br />
    type: 类型<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;name 歌曲名<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;artist 歌手<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;url 链接<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pic 封面<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;lrc 歌词<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;song 单曲<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;playlist 歌单<br /><br />
    id: 类型ID（封面ID/单曲ID/歌单ID）<br />
    <br />
    GitHub：<a href="https://github.com/injahow/meting-api" target="_blank">meting-api</a>，此API基于 <a href="https://github.com/metowolf/Meting" target="_blank">Meting</a> 构建，<a href="https://jinghuashang.cn" target="_blank">jinghuashang</a> 提供服务 ,部署于<a href="https://vercel.com" target="_blank">Vercel</a><br/><br/>
    例如：<a href="<?php echo API_URI ?>?type=url&id=416892104" target="_blank"><?php echo API_URI ?>?type=url&id=416892104</a><br />
    <a href="<?php echo API_URI ?>?type=song&id=591321" target="_blank" style="padding-left:48px"><?php echo API_URI ?>?type=song&id=591321</a><br />
    <a href="<?php echo API_URI ?>?type=playlist&id=2619366284" target="_blank" style="padding-left:48px"><?php echo API_URI ?>?type=playlist&id=2619366284</a>
</body>

</html>
