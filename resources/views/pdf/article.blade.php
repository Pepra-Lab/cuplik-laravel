<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $article->judul }} — Cuplik.com</title>
    <style>
        @page {
            margin: 18mm 18mm 20mm 18mm;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1a1a1a;
            font-size: 10pt;
            line-height: 1.55;
            background: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Top Brand Strip */
        .brand-strip {
            width: 100%;
            height: 4px;
            margin-bottom: 12px;
        }
        .brand-strip-red {
            width: 50%;
            height: 4px;
            background-color: #d60000;
            float: left;
        }
        .brand-strip-green {
            width: 50%;
            height: 4px;
            background-color: #008a24;
            float: right;
        }
        .clearfix {
            clear: both;
        }

        /* Header Table */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 2px solid #111111;
        }
        .header-logo-cell {
            vertical-align: middle;
            width: 60%;
        }
        .header-meta-cell {
            vertical-align: middle;
            width: 40%;
            text-align: right;
            font-size: 7.5pt;
            color: #555555;
            line-height: 1.35;
        }

        .logo-box {
            display: inline-block;
            vertical-align: middle;
            background-color: #d60000;
            color: #ffffff;
            font-weight: 900;
            font-size: 18pt;
            width: 32px;
            height: 32px;
            line-height: 32px;
            text-align: center;
            border-radius: 4px;
            margin-right: 8px;
        }
        .logo-text-title {
            font-size: 18pt;
            font-weight: 900;
            letter-spacing: -0.5px;
            margin: 0;
            padding: 0;
            line-height: 1;
        }
        .brand-cuplik {
            color: #d60000;
        }
        .brand-com {
            color: #008a24;
        }
        .logo-tagline {
            font-size: 7.5pt;
            color: #666666;
            font-weight: bold;
            margin-top: 3px;
        }

        /* Category Badge */
        .category-badge {
            display: inline-block;
            background-color: #d60000;
            color: #ffffff;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 3px 8px;
            border-radius: 3px;
            margin-top: 4px;
            margin-bottom: 8px;
        }

        /* Title */
        .article-title {
            font-size: 18pt;
            font-weight: bold;
            line-height: 1.25;
            color: #111111;
            margin: 0 0 12px 0;
        }

        /* Meta Table */
        .meta-box {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 14px;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            color: #475569;
        }
        .meta-table td {
            padding: 2px 0;
        }
        .meta-label {
            font-weight: bold;
            color: #1e293b;
        }
        .meta-url {
            color: #008a24;
            text-decoration: none;
            word-break: break-all;
        }

        /* Lead */
        .article-lead {
            background-color: #f9fafb;
            border-left: 4px solid #d60000;
            padding: 10px 14px;
            font-size: 10pt;
            font-weight: bold;
            font-style: italic;
            color: #333333;
            margin-bottom: 14px;
            line-height: 1.5;
        }

        /* Images */
        .image-container {
            width: 100%;
            text-align: center;
            margin: 12px 0 16px 0;
        }
        .featured-img {
            max-width: 100%;
            max-height: 320px;
            height: auto;
            border-radius: 4px;
            display: block;
            margin: 0 auto;
        }
        .img-caption {
            font-size: 8pt;
            font-style: italic;
            color: #64748b;
            margin-top: 5px;
            text-align: center;
        }

        /* Content */
        .article-body {
            font-size: 10pt;
            line-height: 1.65;
            color: #1e293b;
            text-align: justify;
        }
        .article-body p {
            margin: 0 0 12px 0;
        }
        .article-body figure {
            margin: 14px auto;
            text-align: center;
            display: block;
        }
        .article-body figure img {
            max-width: 90%;
            max-height: 280px;
            height: auto;
            border-radius: 4px;
            margin: 0 auto;
            display: block;
        }
        .article-body figcaption {
            font-size: 8pt;
            font-style: italic;
            color: #64748b;
            margin-top: 4px;
        }
        .signoff {
            font-size: 9pt;
            font-weight: bold;
            color: #64748b;
            font-style: italic;
            margin-top: 10px;
        }

        /* Tags */
        .tags-container {
            margin-top: 16px;
            padding-top: 10px;
            border-top: 1px dashed #cbd5e1;
            font-size: 8pt;
        }
        .tag-pill {
            display: inline-block;
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 2px 7px;
            border-radius: 3px;
            margin-right: 4px;
            margin-bottom: 4px;
            font-weight: 600;
        }

        /* Footer */
        .footer-box {
            margin-top: 24px;
            padding-top: 12px;
            border-top: 2px solid #008a24;
            font-size: 7.5pt;
            color: #64748b;
            line-height: 1.45;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-left {
            width: 70%;
            vertical-align: top;
        }
        .footer-right {
            width: 30%;
            vertical-align: top;
            text-align: right;
        }
        .badge-verified {
            color: #008a24;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <!-- Brand Colored Strip -->
    <div class="brand-strip">
        <div class="brand-strip-red"></div>
        <div class="brand-strip-green"></div>
        <div class="clearfix"></div>
    </div>

    <!-- Newspaper Header -->
    <table class="header-table">
        <tr>
            <td class="header-logo-cell">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td style="vertical-align: middle;">
                            <div class="logo-box">C</div>
                        </td>
                        <td style="vertical-align: middle;">
                            <div class="logo-text-title">
                                <span class="brand-cuplik">Cuplik</span><span class="brand-com">.com</span>
                            </div>
                            <div class="logo-tagline">Beritanya Unik &amp; Menggelitik · Portal Berita Terkini</div>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="header-meta-cell">
                <div><strong>Edisi Digital (PDF)</strong></div>
                <div>Diunduh: {{ $downloadDate }}</div>
                <div class="badge-verified">SMSI Terverifikasi</div>
                <div>SK Kemenkumham AHU-0039651.AH.01.01.2019</div>
            </td>
        </tr>
    </table>

    <!-- Category Badge -->
    <div>
        <span class="category-badge">{{ $article->category->nama ?? 'Berita' }}</span>
    </div>

    <!-- Headline -->
    <h1 class="article-title">{{ $article->judul }}</h1>

    <!-- Metadata Information -->
    <div class="meta-box">
        <table class="meta-table">
            <tr>
                <td style="width: 50%;">
                    <span class="meta-label">Penulis:</span> {{ $article->penulis_nama ?: 'Redaksi Cuplik' }}
                    @if($article->editor_nama)
                        <span style="color: #94a3b8;">|</span> <span class="meta-label">Editor:</span> {{ $article->editor_nama }}
                    @endif
                </td>
                <td style="width: 50%; text-align: right;">
                    <span class="meta-label">Tanggal Terbit:</span> {{ $article->formatted_date }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="meta-label">Dibaca:</span> {{ number_format($article->dibaca) }} kali
                    @if($article->lokasi)
                        <span style="color: #94a3b8;">|</span> <span class="meta-label">Lokasi:</span> {{ $article->lokasi }}
                    @endif
                </td>
                <td style="text-align: right;">
                    <span class="meta-label">Tautan:</span> <a href="{{ $articleUrl }}" class="meta-url">{{ $articleUrl }}</a>
                </td>
            </tr>
        </table>
    </div>

    <!-- Featured Image -->
    @if($headerImage)
        <div class="image-container">
            <img src="{{ $headerImage }}" alt="{{ $article->judul }}" class="featured-img">
            <div class="img-caption">
                {{ $article->caption_foto ?: 'Dokumentasi Liputan Khusus Redaksi Cuplik.com' }}
            </div>
        </div>
    @endif

    @if($headerImage2)
        <div class="image-container">
            <img src="{{ $headerImage2 }}" alt="{{ $article->judul }} - Gambar 2" class="featured-img">
            @if($article->caption_foto_2)
                <div class="img-caption">
                    {{ $article->caption_foto_2 }}
                </div>
            @endif
        </div>
    @endif

    <!-- Lead / Ringkasan -->
    @if($article->lead)
        <div class="article-lead">
            {{ $article->lead }}
        </div>
    @endif

    <!-- Article Content -->
    <div class="article-body">
        {!! $processedContent !!}
        <div class="signoff">(cpl/red)</div>
    </div>

    <!-- Tags -->
    @if($article->tags && $article->tags->count() > 0)
        <div class="tags-container">
            <strong style="color: #1e293b; margin-right: 6px;">Topik Terkait:</strong>
            @foreach($article->tags as $tag)
                <span class="tag-pill">#{{ $tag->nama }}</span>
            @endforeach
        </div>
    @endif

    <!-- Document Footer -->
    <div class="footer-box">
        <table class="footer-table">
            <tr>
                <td class="footer-left">
                    <strong>© {{ date('Y') }} Cuplik.com — Hak Cipta Dilindungi Undang-Undang.</strong><br>
                    Dokumen ini merupakan arsip digital resmi dari portal berita <em>Cuplik.com</em>.<br>
                    Tautan daring artikel asli: <a href="{{ $articleUrl }}" style="color: #008a24; text-decoration: none;">{{ $articleUrl }}</a>
                </td>
                <td class="footer-right">
                    <strong>Cuplik Media Network</strong><br>
                    Indramayu, Jawa Barat<br>
                    Edisi Pantura &amp; Nasional
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
