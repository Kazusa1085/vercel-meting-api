<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="description" content="基于 Meting 构建的音乐数据 API，提供网易云音乐 / QQ音乐的歌曲直链、封面、歌词与歌单查询，部署于 Vercel。">
    <meta name="theme-color" content="#fbfafc" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#15111c" media="(prefers-color-scheme: dark)">
    <title>Kazusa Meting API</title>
    <link rel="shortcut icon" href="https://www.raana.icu/images/icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <script>
        // 在首次绘制前应用已保存的主题，避免切换闪烁
        (function () {
            try {
                var saved = localStorage.getItem('meting-theme');
                if (saved === 'light' || saved === 'dark') {
                    document.documentElement.setAttribute('data-theme', saved);
                }
            } catch (e) {}
        })();
    </script>

    <style>
        :root {
            --bg: #fbfafc;
            --surface: #ffffff;
            --surface-2: #f3eff7;
            --text: #1c1622;
            --text-muted: #6e6577;
            --border: #e7e1ec;
            --accent: #c81e5c;
            --accent-strong: #a5164b;
            --accent-soft: #fbe4ed;
            --code-bg: #f3eff7;
            --code-text: #7a2743;
            --shadow: rgba(28, 22, 34, 0.08);
            --method-get: #1e9e6b;
            --method-get-soft: #e3f5ec;

            --font-display: 'Bricolage Grotesque', 'PingFang SC', 'Microsoft YaHei', ui-sans-serif, system-ui, sans-serif;
            --font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'PingFang SC', 'Microsoft YaHei', 'Segoe UI', sans-serif;
            --font-mono: 'JetBrains Mono', ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
        }

        @media (prefers-color-scheme: dark) {
            :root:not([data-theme]) {
                --bg: #15111c;
                --surface: #1e1826;
                --surface-2: #251e30;
                --text: #f3eef7;
                --text-muted: #ab9fb6;
                --border: #332b3e;
                --accent: #ff6e9c;
                --accent-strong: #ff8fb2;
                --accent-soft: #3b2130;
                --code-bg: #251e30;
                --code-text: #ffb8cf;
                --shadow: rgba(0, 0, 0, 0.4);
                --method-get: #3ddc97;
                --method-get-soft: rgba(61, 220, 151, 0.12);
            }
        }

        :root[data-theme="dark"] {
            --bg: #15111c;
            --surface: #1e1826;
            --surface-2: #251e30;
            --text: #f3eef7;
            --text-muted: #ab9fb6;
            --border: #332b3e;
            --accent: #ff6e9c;
            --accent-strong: #ff8fb2;
            --accent-soft: #3b2130;
            --code-bg: #251e30;
            --code-text: #ffb8cf;
            --shadow: rgba(0, 0, 0, 0.4);
            --method-get: #3ddc97;
            --method-get-soft: rgba(61, 220, 151, 0.12);
        }

        * { box-sizing: border-box; }

        html { -webkit-text-size-adjust: 100%; }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: var(--font-body);
            font-size: 16px;
            line-height: 1.6;
            transition: background-color .25s ease, color .25s ease;
        }

        a { color: var(--accent); text-decoration: none; }
        a:hover { text-decoration: underline; }

        :focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
            border-radius: 4px;
        }

        .wrap {
            max-width: 760px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ---------- 顶部导航 ---------- */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background: color-mix(in srgb, var(--bg) 82%, transparent);
            border-bottom: 1px solid var(--border);
        }

        .site-header .wrap {
            max-width: 800px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            height: 60px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1rem;
            color: var(--text);
            white-space: nowrap;
        }
        .brand:hover { text-decoration: none; }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 22px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        .nav-links a { color: var(--text-muted); font-weight: 500; }
        .nav-links a:hover { color: var(--accent); text-decoration: none; }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-muted);
            cursor: pointer;
        }
        .icon-btn:hover { color: var(--accent); border-color: var(--accent); }
        .icon-btn svg { width: 17px; height: 17px; }
        .theme-toggle .icon-moon { display: none; }
        :root[data-theme="dark"] .theme-toggle .icon-sun { display: none; }
        :root[data-theme="dark"] .theme-toggle .icon-moon { display: block; }
        @media (prefers-color-scheme: dark) {
            :root:not([data-theme]) .theme-toggle .icon-sun { display: none; }
            :root:not([data-theme]) .theme-toggle .icon-moon { display: block; }
        }

        /* ---------- EQ 图标 ---------- */
        .eq { display: inline-flex; align-items: flex-end; gap: 3px; height: 16px; flex-shrink: 0; }
        .eq span { width: 3px; border-radius: 2px; background: var(--accent); animation: eq 1.15s ease-in-out infinite; }
        .eq span:nth-child(1) { height: 40%; animation-delay: -0.9s; }
        .eq span:nth-child(2) { height: 100%; animation-delay: -0.5s; }
        .eq span:nth-child(3) { height: 65%; animation-delay: -1.05s; }
        .eq span:nth-child(4) { height: 85%; animation-delay: -0.2s; }
        .eq--lg span { width: 5px; }
        .eq--lg { height: 28px; gap: 5px; }
        @keyframes eq { 0%, 100% { transform: scaleY(0.35); } 50% { transform: scaleY(1); } }
        @media (prefers-reduced-motion: reduce) {
            .eq span { animation: none !important; height: 60% !important; }
        }

        /* ---------- Hero ---------- */
        .hero {
            position: relative;
            padding: 72px 0 56px;
            overflow: hidden;
        }
        .hero::before {
            content: "";
            position: absolute;
            top: -120px;
            right: -80px;
            width: 420px;
            height: 420px;
            background: radial-gradient(circle, var(--accent-soft) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-inner { position: relative; }

        h1.title {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: clamp(2.1rem, 1.7rem + 1.6vw, 2.9rem);
            line-height: 1.08;
            letter-spacing: -0.02em;
            margin: 0 0 18px;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .lead {
            font-size: 1.06rem;
            line-height: 1.8;
            color: var(--text-muted);
            max-width: 60ch;
            margin: 0 0 28px;
        }
        .lead strong { color: var(--text); font-weight: 600; }

        .badges { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 28px; }
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: var(--surface);
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
        }
        .pill .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--method-get); }

        .base-url {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 12px 12px 16px;
            box-shadow: 0 8px 24px -12px var(--shadow);
        }
        .base-url .label {
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            flex-shrink: 0;
        }
        .base-url code {
            flex: 1;
            font-family: var(--font-mono);
            font-size: 0.88rem;
            color: var(--text);
            overflow-x: auto;
            white-space: nowrap;
        }

        /* ---------- Section 通用 ---------- */
        section.block { padding: 40px 0; border-top: 1px solid var(--border); }

        h2.h2 {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0 0 10px;
            letter-spacing: -0.01em;
        }
        .section-desc {
            color: var(--text-muted);
            font-size: 0.98rem;
            margin: 0 0 28px;
            max-width: 60ch;
        }

        /* ---------- 参数表 ---------- */
        .table-wrap {
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            background: var(--surface);
        }
        table.params { width: 100%; border-collapse: collapse; font-size: 0.92rem; }
        table.params th {
            text-align: left;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            background: var(--surface-2);
            padding: 11px 16px;
            font-weight: 600;
            border-bottom: 1px solid var(--border);
        }
        table.params td {
            padding: 16px;
            vertical-align: top;
            border-bottom: 1px solid var(--border);
        }
        table.params tr:last-child td { border-bottom: none; }
        table.params td:first-child { white-space: nowrap; width: 1%; }

        .param-name {
            font-family: var(--font-mono);
            font-weight: 600;
            color: var(--accent);
            font-size: 0.92rem;
        }
        .req {
            display: inline-block;
            margin-top: 6px;
            font-size: 0.68rem;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 999px;
            letter-spacing: 0.02em;
        }
        .req--yes { background: var(--accent-soft); color: var(--accent-strong); }
        .req--no { background: var(--surface-2); color: var(--text-muted); }

        .value-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 6px 10px;
            margin-top: 10px;
        }
        .value-grid div { font-size: 0.86rem; color: var(--text-muted); }
        .value-grid code { margin-right: 4px; }

        code, .code-chip {
            font-family: var(--font-mono);
            background: var(--code-bg);
            color: var(--code-text);
            padding: 2px 6px;
            border-radius: 5px;
            font-size: 0.87em;
        }

        .tip {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            padding: 14px 16px;
            border-radius: 12px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            font-size: 0.88rem;
            color: var(--text-muted);
            line-height: 1.7;
        }
        .tip svg { flex-shrink: 0; width: 18px; height: 18px; margin-top: 2px; color: var(--accent); }
        .tip code { font-size: 0.85em; }

        /* ---------- 示例 / endpoint 卡片 ---------- */
        .endpoint {
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--surface);
            padding: 18px 18px 16px;
            margin-bottom: 16px;
        }
        .endpoint:last-child { margin-bottom: 0; }
        .endpoint__head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
            flex-wrap: wrap;
        }
        .method {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            background: var(--method-get-soft);
            color: var(--method-get);
            letter-spacing: 0.03em;
        }
        .endpoint__title { font-weight: 600; font-size: 0.98rem; }
        .endpoint__param { margin-left: auto; font-family: var(--font-mono); font-size: 0.78rem; color: var(--text-muted); }
        .endpoint__desc { color: var(--text-muted); font-size: 0.88rem; margin: 4px 0 14px; }

        .codeblock {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--code-bg);
            border-radius: 10px;
            padding: 11px 8px 11px 14px;
        }
        .codeblock code {
            background: none;
            padding: 0;
            flex: 1;
            overflow-x: auto;
            white-space: nowrap;
            font-size: 0.83rem;
            color: var(--code-text);
        }
        .codeblock code::-webkit-scrollbar { height: 0; }

        .copy-btn {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1px solid transparent;
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
        }
        .copy-btn:hover { color: var(--accent); background: var(--surface); border-color: var(--border); }
        .copy-btn svg { width: 15px; height: 15px; }
        .copy-btn .icon-check { display: none; color: var(--method-get); }
        .copy-btn.copied .icon-copy { display: none; }
        .copy-btn.copied .icon-check { display: block; }

        .try-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 10px;
            font-size: 0.82rem;
            font-weight: 500;
        }
        .try-link svg { width: 13px; height: 13px; }

        /* ---------- Footer ---------- */
        footer.site-footer { padding: 40px 0 60px; border-top: 1px solid var(--border); }
        .footer-links {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }
        .footer-links .label { font-size: 0.88rem; color: var(--text-muted); }
        .link-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 999px;
            background: var(--accent);
            color: #fff;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .link-chip:hover { background: var(--accent-strong); text-decoration: none; }
        .fine-print { font-size: 0.82rem; color: var(--text-muted); }
        .fine-print a { color: var(--text-muted); text-decoration: underline; text-decoration-color: var(--border); }

        @media (max-width: 640px) {
            .wrap { padding: 0 18px; }
            .hero { padding: 44px 0 36px; }
            .nav-links { display: none; }
            h1.title { gap: 12px; }
            .base-url { flex-wrap: wrap; }
            table.params td:first-child { white-space: normal; width: auto; }
            .endpoint__param { margin-left: 0; }
        }
    </style>
</head>

<body>

    <header class="site-header">
        <div class="wrap">
            <a href="#top" class="brand">
                <span class="eq" aria-hidden="true"><span></span><span></span><span></span><span></span></span>
                Meting API
            </a>
            <nav class="nav-links">
                <a href="#parameters">参数说明</a>
                <a href="#quickstart">使用示例</a>
            </nav>
            <div class="nav-right">
                <a class="icon-btn" href="https://github.com/Kazusa1085/vercel-meting-api" target="_blank" rel="noopener" aria-label="查看 GitHub 仓库">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-4.3 1.4-4.3-2.5-6-3m12 5v-3.5c0-1 .1-1.4-.5-2 2.8-.3 5.5-1.4 5.5-6a4.6 4.6 0 0 0-1.3-3.2 4.2 4.2 0 0 0-.1-3.2s-1.1-.3-3.5 1.3a12.3 12.3 0 0 0-6.2 0C6.5 2.8 5.4 3.1 5.4 3.1a4.2 4.2 0 0 0-.1 3.2A4.6 4.6 0 0 0 4 9.5c0 4.6 2.7 5.7 5.5 6-.6.6-.6 1.2-.5 2V21"/></svg>
                </a>
                <button class="icon-btn theme-toggle" id="theme-toggle" type="button" aria-label="切换浅色/深色模式">
                    <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4.2"/><path d="M12 3v2M12 19v2M4.6 4.6l1.4 1.4M18 18l1.4 1.4M3 12h2M19 12h2M4.6 19.4L6 18M18 6l1.4-1.4"/></svg>
                    <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.5A8.5 8.5 0 1 1 9.5 4a6.8 6.8 0 0 0 10.5 10.5z"/></svg>
                </button>
            </div>
        </div>
    </header>

    <main>
        <section class="hero" id="top">
            <div class="wrap hero-inner">
                <h1 class="title">
                    <span class="eq eq--lg" aria-hidden="true"><span></span><span></span><span></span><span></span></span>
                    Meting API
                </h1>

                <p class="lead">
                    基于 <strong>Meting</strong> 构建的音乐数据 API，由
                    <a href="https://www.raana.icu" target="_blank" rel="noopener">Kazusa1085</a> 提供服务，
                    部署于 <a href="https://vercel.com" target="_blank" rel="noopener">Vercel</a>。
                </p>

                <div class="badges">
                    <span class="pill"><span class="dot"></span>Vercel Serverless</span>
                    <span class="pill">PHP 8.5</span>
                    <span class="pill">MIT License</span>
                </div>

                <div class="base-url">
                    <span class="label">Base</span>
                    <code id="base-url"><?= API_URI ?></code>
                    <button class="copy-btn" data-copy-target="base-url" aria-label="复制基础地址" type="button">
                        <svg class="icon-copy" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        <svg class="icon-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                    </button>
                </div>
            </div>
        </section>

        <section class="block" id="parameters">
            <div class="wrap">
                <h2 class="h2">📋 参数说明</h2>
                <p class="section-desc">所有接口均为 GET 请求，通过以下查询参数组合来获取对应的音乐数据。</p>

                <div class="table-wrap">
                    <table class="params">
                        <thead>
                            <tr>
                                <th scope="col">参数</th>
                                <th scope="col">说明</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="param-name">server</span>
                                    <span class="req req--no">可选 · 默认 netease</span>
                                </td>
                                <td>
                                    数据源
                                    <div class="value-grid">
                                        <div><code>netease</code>网易云音乐（默认）</div>
                                        <div><code>tencent</code>QQ音乐</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="param-name">type</span>
                                    <span class="req req--yes">必填</span>
                                </td>
                                <td>
                                    请求类型
                                    <div class="value-grid">
                                        <div><code>name</code>歌曲名</div>
                                        <div><code>artist</code>歌手</div>
                                        <div><code>url</code>链接</div>
                                        <div><code>pic</code>封面</div>
                                        <div><code>lrc</code>歌词</div>
                                        <div><code>song</code>单曲</div>
                                        <div><code>playlist</code>歌单</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="param-name">id</span>
                                    <span class="req req--yes">必填</span>
                                </td>
                                <td>类型 ID，对应封面 ID / 单曲 ID / 歌单 ID</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="tip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 16v-5M12 8h.01"/></svg>
                    <div><code>url</code> 与 <code>pic</code> 会直接 302 重定向到资源地址；<code>song</code> 与 <code>playlist</code> 返回 JSON；其余类型返回纯文本。</div>
                </div>
            </div>
        </section>

        <section class="block" id="quickstart">
            <div class="wrap">
                <h2 class="h2">🚀 使用示例</h2>
                <p class="section-desc">点击复制或直接在新标签页打开，即可查看真实请求结果。</p>

                <div class="endpoint">
                    <div class="endpoint__head">
                        <span class="method">GET</span>
                        <span class="endpoint__title">获取歌曲直链</span>
                        <span class="endpoint__param">type=url</span>
                    </div>
                    <p class="endpoint__desc">重定向至可直接播放 / 下载的音频地址。</p>
                    <div class="codeblock">
                        <code id="ex-url"><?= API_URI ?>?type=url&id=416892104</code>
                        <button class="copy-btn" data-copy-target="ex-url" aria-label="复制链接" type="button">
                            <svg class="icon-copy" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            <svg class="icon-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        </button>
                    </div>
                    <a class="try-link" href="<?= API_URI ?>?type=url&id=416892104" target="_blank" rel="noopener">
                        在新标签页打开
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M8 7h9v9"/></svg>
                    </a>
                </div>

                <div class="endpoint">
                    <div class="endpoint__head">
                        <span class="method">GET</span>
                        <span class="endpoint__title">获取单曲信息</span>
                        <span class="endpoint__param">type=song</span>
                    </div>
                    <p class="endpoint__desc">返回歌曲名、歌手及 url / pic / lrc 的完整 JSON。</p>
                    <div class="codeblock">
                        <code id="ex-song"><?= API_URI ?>?type=song&id=591321</code>
                        <button class="copy-btn" data-copy-target="ex-song" aria-label="复制链接" type="button">
                            <svg class="icon-copy" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            <svg class="icon-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        </button>
                    </div>
                    <a class="try-link" href="<?= API_URI ?>?type=song&id=591321" target="_blank" rel="noopener">
                        在新标签页打开
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M8 7h9v9"/></svg>
                    </a>
                </div>

                <div class="endpoint">
                    <div class="endpoint__head">
                        <span class="method">GET</span>
                        <span class="endpoint__title">获取歌单</span>
                        <span class="endpoint__param">type=playlist</span>
                    </div>
                    <p class="endpoint__desc">返回歌单内所有歌曲的 JSON 数组，可直接用于 APlayer 等播放器。</p>
                    <div class="codeblock">
                        <code id="ex-playlist"><?= API_URI ?>?type=playlist&id=2619366284</code>
                        <button class="copy-btn" data-copy-target="ex-playlist" aria-label="复制链接" type="button">
                            <svg class="icon-copy" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            <svg class="icon-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        </button>
                    </div>
                    <a class="try-link" href="<?= API_URI ?>?type=playlist&id=2619366284" target="_blank" rel="noopener">
                        在新标签页打开
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M8 7h9v9"/></svg>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="wrap">
            <div class="footer-links">
                <span class="label">🔗 基于</span>
                <a class="link-chip" href="https://github.com/jinghuashang/vercel-meting-api" target="_blank" rel="noopener">Meting</a>
            </div>
            <p class="fine-print">MIT License · Copyright &copy; 2019-2026 Kazusa1085</p>
        </div>
    </footer>

    <script>
        (function () {
            var root = document.documentElement;
            var toggle = document.getElementById('theme-toggle');
            if (toggle) {
                toggle.addEventListener('click', function () {
                    var mql = window.matchMedia('(prefers-color-scheme: dark)');
                    var current = root.getAttribute('data-theme') || (mql.matches ? 'dark' : 'light');
                    var next = current === 'dark' ? 'light' : 'dark';
                    root.setAttribute('data-theme', next);
                    try { localStorage.setItem('meting-theme', next); } catch (e) {}
                });
            }

            document.querySelectorAll('.copy-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var targetId = btn.getAttribute('data-copy-target');
                    var el = document.getElementById(targetId);
                    if (!el) return;
                    var text = el.textContent.trim();

                    function done() {
                        btn.classList.add('copied');
                        setTimeout(function () { btn.classList.remove('copied'); }, 1500);
                    }

                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(text).then(done).catch(function () {});
                    } else {
                        var ta = document.createElement('textarea');
                        ta.value = text;
                        ta.style.position = 'fixed';
                        ta.style.opacity = '0';
                        document.body.appendChild(ta);
                        ta.select();
                        try { document.execCommand('copy'); done(); } catch (e) {}
                        document.body.removeChild(ta);
                    }
                });
            });
        })();
    </script>
</body>

</html>
