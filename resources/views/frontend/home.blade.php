{{-- resources/views/frontend/home.blade.php --}}
@extends('layouts.frontend')

@section('title', __('common.brand') . ' | ' . __('common.brand_tagline'))

@section('content')

{{-- ============================================ --}}
{{-- HERO --}}
{{-- ============================================ --}}
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-star"></i>
                {{ __('frontend.hero.badge') }}
            </div>

            <h1 class="hero-title">
                {!! __('frontend.hero.title') !!}
            </h1>

            <p class="hero-description">
                {{ __('frontend.hero.description') }}
            </p>

            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn btn-gold">
                    <i class="fas fa-rocket"></i>
                    {{ __('frontend.hero.start') }}
                </a>
                <a href="#services" class="btn btn-outline">
                    <i class="fas fa-briefcase"></i>
                    {{ __('frontend.hero.view_services') }}
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- STATS --}}
{{-- ============================================ --}}
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-number">150+</div>
                <div class="stat-label">{{ __('frontend.stats.companies') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-store"></i></div>
                <div class="stat-number">500+</div>
                <div class="stat-label">{{ __('frontend.stats.sellers') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="stat-number">10000+</div>
                <div class="stat-label">{{ __('frontend.stats.orders') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-smile"></i></div>
                <div class="stat-number">98%</div>
                <div class="stat-label">{{ __('frontend.stats.satisfaction') }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- SERVICES --}}
{{-- ============================================ --}}
<section class="section" id="services">
    <div class="container">
        <div class="section-header">
            <div class="section-subtitle">{{ __('frontend.services.subtitle') }}</div>
            <h2 class="section-title">{{ __('frontend.services.title') }}</h2>
            <div class="section-divider"></div>
            <p class="section-description">{{ __('frontend.services.description') }}</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-handshake"></i></div>
                <h3 class="service-title">{{ __('frontend.services.items.connection.title') }}</h3>
                <p class="service-description">{{ __('frontend.services.items.connection.description') }}</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-shield-alt"></i></div>
                <h3 class="service-title">{{ __('frontend.services.items.escrow.title') }}</h3>
                <p class="service-description">{{ __('frontend.services.items.escrow.description') }}</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-chart-line"></i></div>
                <h3 class="service-title">{{ __('frontend.services.items.analytics.title') }}</h3>
                <p class="service-description">{{ __('frontend.services.items.analytics.description') }}</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-file-contract"></i></div>
                <h3 class="service-title">{{ __('frontend.services.items.contracts.title') }}</h3>
                <p class="service-description">{{ __('frontend.services.items.contracts.description') }}</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-truck"></i></div>
                <h3 class="service-title">{{ __('frontend.services.items.logistics.title') }}</h3>
                <p class="service-description">{{ __('frontend.services.items.logistics.description') }}</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-headset"></i></div>
                <h3 class="service-title">{{ __('frontend.services.items.support.title') }}</h3>
                <p class="service-description">{{ __('frontend.services.items.support.description') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- PROJECTS --}}
{{-- ============================================ --}}
<section class="section" id="projects">
    <div class="container">
        <div class="section-header">
            <div class="section-subtitle">{{ __('frontend.projects.subtitle') }}</div>
            <h2 class="section-title">{{ __('frontend.projects.title') }}</h2>
            <div class="section-divider"></div>
            <p class="section-description">{{ __('frontend.projects.description') }}</p>
        </div>

        <div class="projects-grid">
            <div class="project-card">
                <div class="project-image"><i class="fas fa-shopping-cart"></i></div>
                <div class="project-body">
                    <div class="project-category">{{ __('frontend.projects.items.b2b.category') }}</div>
                    <h3 class="project-title">{{ __('frontend.projects.items.b2b.title') }}</h3>
                    <p class="project-description">{{ __('frontend.projects.items.b2b.description') }}</p>
                </div>
            </div>
            <div class="project-card">
                <div class="project-image"><i class="fas fa-cubes"></i></div>
                <div class="project-body">
                    <div class="project-category">{{ __('frontend.projects.items.supply.category') }}</div>
                    <h3 class="project-title">{{ __('frontend.projects.items.supply.title') }}</h3>
                    <p class="project-description">{{ __('frontend.projects.items.supply.description') }}</p>
                </div>
            </div>
            <div class="project-card">
                <div class="project-image"><i class="fas fa-mobile-alt"></i></div>
                <div class="project-body">
                    <div class="project-category">{{ __('frontend.projects.items.mobile.category') }}</div>
                    <h3 class="project-title">{{ __('frontend.projects.items.mobile.title') }}</h3>
                    <p class="project-description">{{ __('frontend.projects.items.mobile.description') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- WHY US --}}
{{-- ============================================ --}}
<section class="section" id="why-us">
    <div class="container">
        <div class="section-header">
            <div class="section-subtitle">{{ __('frontend.why_us.subtitle') }}</div>
            <h2 class="section-title">{{ __('frontend.why_us.title') }}</h2>
            <div class="section-divider"></div>
            <p class="section-description">{{ __('frontend.why_us.description') }}</p>
        </div>

        <div class="why-grid">
            <div class="why-item">
                <div class="why-icon"><i class="fas fa-shield-alt"></i></div>
                <h3 class="why-title">{{ __('frontend.why_us.items.security.title') }}</h3>
                <p class="why-description">{{ __('frontend.why_us.items.security.description') }}</p>
            </div>
            <div class="why-item">
                <div class="why-icon"><i class="fas fa-bolt"></i></div>
                <h3 class="why-title">{{ __('frontend.why_us.items.speed.title') }}</h3>
                <p class="why-description">{{ __('frontend.why_us.items.speed.description') }}</p>
            </div>
            <div class="why-item">
                <div class="why-icon"><i class="fas fa-globe"></i></div>
                <h3 class="why-title">{{ __('frontend.why_us.items.coverage.title') }}</h3>
                <p class="why-description">{{ __('frontend.why_us.items.coverage.description') }}</p>
            </div>
            <div class="why-item">
                <div class="why-icon"><i class="fas fa-headset"></i></div>
                <h3 class="why-title">{{ __('frontend.why_us.items.support.title') }}</h3>
                <p class="why-description">{{ __('frontend.why_us.items.support.description') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- CTA --}}
{{-- ============================================ --}}
<section class="section">
    <div class="container">
        <div class="cta-section">
            <h2 class="cta-title">{{ __('frontend.cta.title') }}</h2>
            <p class="cta-description">{{ __('frontend.cta.description') }}</p>
            <div class="cta-actions">
                <a href="{{ route('register') }}" class="btn btn-gold">
                    <i class="fas fa-user-plus"></i>
                    {{ __('frontend.cta.register') }}
                </a>
                <a href="#contact" class="btn btn-outline">
                    <i class="fas fa-paper-plane"></i>
                    {{ __('frontend.cta.contact') }}
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
