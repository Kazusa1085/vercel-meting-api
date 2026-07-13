<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="robots" content="noindex">
    <meta name="theme-color" content="#fbfafc" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#15111c" media="(prefers-color-scheme: dark)">
    <title>404 · Kazusa Meting API</title>
    <link rel="shortcut icon" href="https://www.raana.icu/images/icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <script>
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
        }

        * { box-sizing: border-box; }
        html { -webkit-text-size-adjust: 100%; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--bg);
            color: var(--text);
            font-family: var(--font-body);
            line-height: 1.6;
        }

        a { color: var(--accent); text-decoration: none; }
        a:hover { text-decoration: underline; }
        :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; border-radius: 4px; }

        .wrap { max-width: 760px; margin: 0 auto; padding: 0 24px; width: 100%; }

        .site-header {
            border-bottom: 1px solid var(--border);
        }
        .site-header .wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
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
        }
        .brand:hover { text-decoration: none; }

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

        .eq { display: inline-flex; align-items: flex-end; gap: 3px; height: 16px; flex-shrink: 0; }
        .eq span { width: 3px; border-radius: 2px; background: var(--accent); }
        .eq span:nth-child(1) { height: 30%; }
        .eq span:nth-child(2) { height: 55%; }
        .eq span:nth-child(3) { height: 20%; }
        .eq span:nth-child(4) { height: 40%; }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 0;
        }

        .content { text-align: center; max-width: 460px; }

        .code {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: clamp(4rem, 3rem + 4vw, 6rem);
            line-height: 1;
            letter-spacing: -0.02em;
            margin: 0 0 16px;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        h1.title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.4rem;
            margin: 0 0 14px;
        }

        .desc {
            color: var(--text-muted);
            font-size: 0.98rem;
            line-height: 1.8;
            margin: 0 0 32px;
        }
        .desc code {
            font-family: var(--font-mono);
            background: var(--surface-2);
            color: var(--accent);
            padding: 2px 6px;
            border-radius: 5px;
            font-size: 0.88em;
        }

        .actions { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 999px;
            background: var(--accent);
            color: #fff;
            font-size: 0.92rem;
            font-weight: 600;
        }
        .btn-primary:hover { background: var(--accent-strong); text-decoration: none; }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 999px;
            border: 1px solid var(--border);
            color: var(--text-muted);
            font-size: 0.92rem;
            font-weight: 500;
        }
        .btn-ghost:hover { color: var(--accent); border-color: var(--accent); text-decoration: none; }

        .path-hint {
            margin-top: 28px;
            font-size: 0.8rem;
            color: var(--text-muted);
            font-family: var(--font-mono);
        }
    </style>
</head>

<body>
    <header class="site-header">
        <div class="wrap">
            <a href="/" class="brand">
                <span class="eq" aria-hidden="true"><span></span><span></span><span></span><span></span></span>
                Meting API
            </a>
            <button class="icon-btn theme-toggle" id="theme-toggle" type="button" aria-label="切换浅色/深色模式">
                <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4.2"/><path d="M12 3v2M12 19v2M4.6 4.6l1.4 1.4M18 18l1.4 1.4M3 12h2M19 12h2M4.6 19.4L6 18M18 6l1.4-1.4"/></svg>
                <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.5A8.5 8.5 0 1 1 9.5 4a6.8 6.8 0 0 0 10.5 10.5z"/></svg>
            </button>
        </div>
    </header>

    <main>
        <div class="wrap">
            <div class="content">
                <p class="code">404</p>
                <h1 class="title">这个页面不存在，像放错了曲目</h1>
                <p class="desc">
                    如果你是想查看接口文档，请返回首页；
                    如果是在调用接口，请检查 <code>type</code>、<code>id</code> 等参数是否正确。
                </p>
                <div class="actions">
                    <a class="btn-primary" href="/">返回首页</a>
                    <a class="btn-ghost" href="/?type=song&id=591321">查看示例请求</a>
                </div>
                <p class="path-hint"><?= htmlspecialchars(strtok($_SERVER['REQUEST_URI'], '?'), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </div>
    </main>

    <script>
        (function () {
            var root = document.documentElement;
            var toggle = document.getElementById('theme-toggle');
            if (!toggle) return;
            toggle.addEventListener('click', function () {
                var mql = window.matchMedia('(prefers-color-scheme: dark)');
                var current = root.getAttribute('data-theme') || (mql.matches ? 'dark' : 'light');
                var next = current === 'dark' ? 'light' : 'dark';
                root.setAttribute('data-theme', next);
                try { localStorage.setItem('meting-theme', next); } catch (e) {}
            });
        })();
    </script>
</body>

</html>
