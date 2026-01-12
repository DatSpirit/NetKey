<svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <defs>
        <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#4F46E5;stop-opacity:1" /> <!-- Indigo-600 -->
            <stop offset="100%" style="stop-color:#3B82F6;stop-opacity:1" /> <!-- Blue-500 -->
        </linearGradient>
    </defs>
    <!-- Network Nodes -->
    <circle cx="20" cy="50" r="6" fill="url(#logoGradient)" opacity="0.8" />
    <circle cx="80" cy="50" r="6" fill="url(#logoGradient)" opacity="0.8" />
    <circle cx="50" cy="20" r="6" fill="url(#logoGradient)" opacity="0.8" />
    <circle cx="50" cy="80" r="6" fill="url(#logoGradient)" opacity="0.8" />

    <!-- Connecting Lines -->
    <path d="M26 50 H74 M50 26 V74" stroke="url(#logoGradient)" stroke-width="3" opacity="0.5" />

    <!-- Central Key Shape -->
    <path d="M50 35 
             C58 35 65 42 65 50 
             C65 58 58 65 50 65 
             C42 65 35 58 35 50 
             C35 42 42 35 50 35 Z 
             M50 55 V75 L45 80 L50 85 L45 90 L50 95" stroke="url(#logoGradient)" stroke-width="0" fill="white" />

    <!-- Stylized Modern Key -->
    <path d="M60 40 
             A 12 12 0 1 0 45 55 
             V 85 
             L 55 85 
             L 55 75 
             L 50 75 
             L 50 65 
             L 55 65 
             L 55 52 
             A 12 12 0 0 0 60 40 Z" fill="url(#logoGradient)" />
    <circle cx="53" cy="40" r="4" fill="white" />
</svg>