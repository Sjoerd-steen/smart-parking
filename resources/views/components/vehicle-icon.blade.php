@php
    $type = $type ?? 'Auto';
    $class = $class ?? '';
@endphp

@switch($type)
    @case('Auto')
        <svg class="{{ $class }}" viewBox="0 0 100 50" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 30 L15 15 Q15 10 20 10 L80 10 Q85 10 85 15 L90 30 M25 30 L75 30 M30 30 L30 35 Q30 38 27 38 L23 38 Q20 38 20 35 L20 30 M70 30 L70 35 Q70 38 73 38 L77 38 Q80 38 80 35 L80 30 M15 30 L85 30 L85 25 Q85 20 80 18 L20 18 Q15 20 15 25 Z" fill="currentColor"/>
        </svg>
    @break
    
    @case('Motor')
        <svg class="{{ $class }}" viewBox="0 0 100 60" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="25" cy="40" rx="12" ry="15" stroke="currentColor" stroke-width="2" fill="none"/>
            <ellipse cx="75" cy="40" rx="12" ry="15" stroke="currentColor" stroke-width="2" fill="none"/>
            <path d="M37 40 L63 40" stroke="currentColor" stroke-width="2"/>
            <path d="M45 15 L50 8 L55 15 M50 15 L50 35" stroke="currentColor" stroke-width="2" fill="none"/>
            <rect x="40" y="25" width="20" height="12" rx="2" fill="currentColor"/>
        </svg>
    @break
    
    @case('Fiets')
        <svg class="{{ $class }}" viewBox="0 0 100 80" xmlns="http://www.w3.org/2000/svg">
            <circle cx="25" cy="50" r="15" stroke="currentColor" stroke-width="2.5" fill="none"/>
            <circle cx="75" cy="50" r="15" stroke="currentColor" stroke-width="2.5" fill="none"/>
            <line x1="25" y1="35" x2="25" y2="50" stroke="currentColor" stroke-width="2" x2="20" y2="40"/>
            <line x1="40" y1="65" x2="75" y2="50" stroke="currentColor" stroke-width="2"/>
            <line x1="40" y1="30" x2="40" y2="65" stroke="currentColor" stroke-width="2"/>
            <circle cx="40" cy="30" r="4" fill="currentColor"/>
            <path d="M35 20 L45 20 L48 25 L32 25 Z" fill="currentColor"/>
        </svg>
    @break
    
    @case('Elektrisch')
        <svg class="{{ $class }}" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(25, 20)">
                <path d="M10 0 L15 10 L12 10 L20 25 L8 15 L11 15 Z" fill="currentColor"/>
                <line x1="20" y1="5" x2="20" y2="20" stroke="currentColor" stroke-width="1"/>
            </g>
            <circle cx="35" cy="60" r="12" stroke="currentColor" stroke-width="2" fill="none"/>
            <circle cx="65" cy="60" r="12" stroke="currentColor" stroke-width="2" fill="none"/>
            <rect x="38" y="45" width="24" height="15" rx="2" fill="currentColor"/>
            <line x1="35" y1="60" x2="65" y2="60" stroke="currentColor" stroke-width="1.5"/>
        </svg>
    @break
    
    @default
        <svg class="{{ $class }}" viewBox="0 0 100 50" xmlns="http://www.w3.org/2000/svg">
            <circle cx="25" cy="30" r="12" stroke="currentColor" stroke-width="2" fill="none"/>
            <circle cx="75" cy="30" r="12" stroke="currentColor" stroke-width="2" fill="none"/>
            <rect x="20" y="15" width="60" height="20" rx="3" fill="currentColor" opacity="0.5"/>
        </svg>
@endswitch
