@extends('layouts.app')

@section('title', $judul)

@section('content')

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Interactive FAQ Accordion Component</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: {
              50: '#eff6ff',
              100: '#dbeafe',
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8',
            }
          }
        }
      }
    }
  </script>
  <!-- Inter Font -->
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    /* Smooth CSS height & opacity transitions for accordion content */
    .accordion-content {
      max-height: 0;
      opacity: 0;
      overflow: hidden;
      transition: max-height 350ms cubic-bezier(0.4, 0, 0.2, 1), opacity 250ms ease-in-out;
    }
    .accordion-content.is-open {
      max-height: 24rem; /* 384px - accommodates FAQ content */
      opacity: 1;
    }
    /* Chevron rotation animation */
    .chevron-icon {
      transition: transform 300ms ease;
    }
    .faq-item.is-active .chevron-icon {
      transform: rotate(180deg);
    }
  </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen transition-colors duration-200">

  <!-- Main Container -->
  <section class="py-12 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
    
    <!-- Header Section with Controls -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 pb-6 border-b border-gray-200 dark:border-gray-800 gap-4">
      <div>
        <h2 class="text-3xl sm:text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
          FAQ
        </h2>
        <p class="mt-2 text-sm sm:text-base text-gray-500 dark:text-gray-400">
          Have questions? We're here to help you understand our license and assets.
        </p>
      </div>

      <!-- Quick Action Controls -->
      <div class="flex flex-wrap items-center gap-3">
        <!-- Search Input -->
        <div class="relative w-full sm:w-64">
          <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </div>
          <input type="text" id="faq-search" placeholder="Search questions..." class="w-full pl-9 pr-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white placeholder-gray-400">
        </div>

        <!-- Mode Toggle (Single vs Multi Expand) -->
        <button id="toggle-multi-mode" class="flex items-center gap-2 px-3 py-2 text-xs font-medium bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
          <span class="w-2 h-2 rounded-full bg-amber-500" id="mode-indicator"></span>
          <span id="mode-label">Single Open Mode</span>
        </button>

        <!-- Dark/Light Theme Switcher -->
        <button id="theme-toggle" type="button" aria-label="Toggle theme" class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <!-- Sun Icon (Dark Mode Active) -->
          <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
          </svg>
          <!-- Moon Icon (Light Mode Active) -->
          <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- 2 Column Responsive Accordion Layout -->
    <div id="faq-container" class="grid gap-6 md:gap-8 md:grid-cols-2 items-start">
      
      <!-- Left Column -->
      <div class="space-y-4">
        
        <!-- FAQ 1 -->
        <div class="faq-item border border-gray-200 dark:border-gray-800 rounded-xl bg-white dark:bg-gray-800 shadow-sm overflow-hidden transition hover:border-gray-300 dark:hover:border-gray-700">
          <button type="button" class="accordion-header flex items-center justify-between w-full p-5 text-left font-medium text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl transition">
            <span class="flex items-center gap-3 pr-2">
              <svg class="flex-shrink-0 w-5 h-5 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
              <span>Apakah boleh mengunakan A.I di pembelajaran?</span>
            </span>
            <svg class="chevron-icon flex-shrink-0 w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div class="accordion-content">
            <div class="accordion-inner px-5 pb-5 pt-1 text-gray-600 dark:text-gray-400 text-sm leading-relaxed border-t border-gray-100 dark:border-gray-700/50">
              <p class="mt-2">You will have access to download the full Figma project including all of the pages, the components, responsive pages, and also the icons, illustrations, and images included in the screens.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 2 -->
        <div class="faq-item border border-gray-200 dark:border-gray-800 rounded-xl bg-white dark:bg-gray-800 shadow-sm overflow-hidden transition hover:border-gray-300 dark:hover:border-gray-700">
          <button type="button" class="accordion-header flex items-center justify-between w-full p-5 text-left font-medium text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl transition">
            <span class="flex items-center gap-3 pr-2">
              <svg class="flex-shrink-0 w-5 h-5 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
              <span>Ada berapa siswa di kelas?</span>
            </span>
            <svg class="chevron-icon flex-shrink-0 w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div class="accordion-content">
            <div class="accordion-inner px-5 pb-5 pt-1 text-gray-600 dark:text-gray-400 text-sm leading-relaxed border-t border-gray-100 dark:border-gray-700/50">
              <p class="mt-2">Once you have purchased either the design, code, or both packages, you will have access to all of the future updates based on the roadmap, free of charge.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 3 -->
        <div class="faq-item border border-gray-200 dark:border-gray-800 rounded-xl bg-white dark:bg-gray-800 shadow-sm overflow-hidden transition hover:border-gray-300 dark:hover:border-gray-700">
          <button type="button" class="accordion-header flex items-center justify-between w-full p-5 text-left font-medium text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl transition">
            <span class="flex items-center gap-3 pr-2">
              <svg class="flex-shrink-0 w-5 h-5 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
              <span>Seperti apa kegiatan di kelas?</span>
            </span>
            <svg class="chevron-icon flex-shrink-0 w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div class="accordion-content">
            <div class="accordion-inner px-5 pb-5 pt-1 text-gray-600 dark:text-gray-400 text-sm leading-relaxed border-t border-gray-100 dark:border-gray-700/50 space-y-2">
              <p class="mt-2">We're aware of the importance of well qualified support, that is why we decided that support will only be provided by the authors that actually worked on this project.</p>
              <p>Feel free to <a href="#" class="font-medium underline text-blue-600 dark:text-blue-400 hover:text-blue-700">contact us</a> and we'll help you out as soon as we can.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 4 -->
        <div class="faq-item border border-gray-200 dark:border-gray-800 rounded-xl bg-white dark:bg-gray-800 shadow-sm overflow-hidden transition hover:border-gray-300 dark:hover:border-gray-700">
          <button type="button" class="accordion-header flex items-center justify-between w-full p-5 text-left font-medium text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl transition">
            <span class="flex items-center gap-3 pr-2">
              <svg class="flex-shrink-0 w-5 h-5 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
              <span>Yang udah dipelajari apa saja?</span>
            </span>
            <svg class="chevron-icon flex-shrink-0 w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div class="accordion-content">
            <div class="accordion-inner px-5 pb-5 pt-1 text-gray-600 dark:text-gray-400 text-sm leading-relaxed border-t border-gray-100 dark:border-gray-700/50 space-y-2">
              <p class="mt-2">You can use Windster for an unlimited amount of projects, whether it's a personal website, a SaaS app, or a website for a client. As long as you don't build a product that will directly compete with Windster either as a UI kit, theme, or template, it's fine.</p>
              <p>Find out more information by <a href="#" class="font-medium underline text-blue-600 dark:text-blue-400 hover:text-blue-700">reading the license</a>.</p>
            </div>
          </div>
        </div>

      </div>

      <!-- Right Column -->
      <div class="space-y-4">
        
        <!-- FAQ 5 -->
        <div class="faq-item border border-gray-200 dark:border-gray-800 rounded-xl bg-white dark:bg-gray-800 shadow-sm overflow-hidden transition hover:border-gray-300 dark:hover:border-gray-700">
          <button type="button" class="accordion-header flex items-center justify-between w-full p-5 text-left font-medium text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl transition">
            <span class="flex items-center gap-3 pr-2">
              <svg class="flex-shrink-0 w-5 h-5 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
              <span></span>
            </span>
            <svg class="chevron-icon flex-shrink-0 w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div class="accordion-content">
            <div class="accordion-inner px-5 pb-5 pt-1 text-gray-600 dark:text-gray-400 text-sm leading-relaxed border-t border-gray-100 dark:border-gray-700/50">
              <p class="mt-2">The free updates that will be provided is based on the <a href="#" class="font-medium underline text-blue-600 dark:text-blue-400 hover:text-blue-700">roadmap</a> that we have laid out for this project. It is also possible that we will provide extra updates outside of the roadmap as well.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 6 -->
        <div class="faq-item border border-gray-200 dark:border-gray-800 rounded-xl bg-white dark:bg-gray-800 shadow-sm overflow-hidden transition hover:border-gray-300 dark:hover:border-gray-700">
          <button type="button" class="accordion-header flex items-center justify-between w-full p-5 text-left font-medium text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl transition">
            <span class="flex items-center gap-3 pr-2">
              <svg class="flex-shrink-0 w-5 h-5 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
              <span>What does the free version include?</span>
            </span>
            <svg class="chevron-icon flex-shrink-0 w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div class="accordion-content">
            <div class="accordion-inner px-5 pb-5 pt-1 text-gray-600 dark:text-gray-400 text-sm leading-relaxed border-t border-gray-100 dark:border-gray-700/50 space-y-2">
              <p class="mt-2">The <a href="#" class="font-medium underline text-blue-600 dark:text-blue-400 hover:text-blue-700">free version</a> of Windster includes a minimal style guidelines, component variants, and a dashboard page with the mobile version alongside it.</p>
              <p>You can use this version for any purposes, because it is open-source under the MIT license.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 7 -->
        <div class="faq-item border border-gray-200 dark:border-gray-800 rounded-xl bg-white dark:bg-gray-800 shadow-sm overflow-hidden transition hover:border-gray-300 dark:hover:border-gray-700">
          <button type="button" class="accordion-header flex items-center justify-between w-full p-5 text-left font-medium text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl transition">
            <span class="flex items-center gap-3 pr-2">
              <svg class="flex-shrink-0 w-5 h-5 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
              <span>What is the difference between Windster and Tailwind UI?</span>
            </span>
            <svg class="chevron-icon flex-shrink-0 w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div class="accordion-content">
            <div class="accordion-inner px-5 pb-5 pt-1 text-gray-600 dark:text-gray-400 text-sm leading-relaxed border-t border-gray-100 dark:border-gray-700/50 space-y-2">
              <p class="mt-2">Although both Windster and Tailwind UI are built for integration with Tailwind CSS, the main difference is in the design, the pages, the extra components and UI elements that Windster includes.</p>
              <p>Additionally, Windster is a project that is still in development, and later it will include both the application, marketing, and e-commerce UI interfaces.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 8 -->
        <div class="faq-item border border-gray-200 dark:border-gray-800 rounded-xl bg-white dark:bg-gray-800 shadow-sm overflow-hidden transition hover:border-gray-300 dark:hover:border-gray-700">
          <button type="button" class="accordion-header flex items-center justify-between w-full p-5 text-left font-medium text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl transition">
            <span class="flex items-center gap-3 pr-2">
              <svg class="flex-shrink-0 w-5 h-5 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
              <span>Can I use Windster in open-source projects?</span>
            </span>
            <svg class="chevron-icon flex-shrink-0 w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div class="accordion-content">
            <div class="accordion-inner px-5 pb-5 pt-1 text-gray-600 dark:text-gray-400 text-sm leading-relaxed border-t border-gray-100 dark:border-gray-700/50 space-y-2">
              <p class="mt-2">Generally, it is accepted to use Windster in open-source projects, as long as it is not a UI library, a theme, a template, a page-builder that would be considered as an alternative to Windster itself.</p>
              <p>With that being said, feel free to use this design kit for your open-source projects.</p>
              <p>Find out more information by <a href="#" class="font-medium underline text-blue-600 dark:text-blue-400 hover:text-blue-700">reading the license</a>.</p>
            </div>
          </div>
        </div>

      </div>

    </div>

    <!-- No Search Results Found Message -->
    <div id="no-results" class="hidden text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No questions found</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search terms.</p>
    </div>

  </section>

  <!-- Accordion & Logic Script -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      let allowMultiple = false; // Default: Single expand mode

      const faqItems = document.querySelectorAll('.faq-item');
      const searchInput = document.getElementById('faq-search');
      const noResults = document.getElementById('no-results');
      const modeBtn = document.getElementById('toggle-multi-mode');
      const modeIndicator = document.getElementById('mode-indicator');
      const modeLabel = document.getElementById('mode-label');

      // Theme toggle setup
      const themeToggleBtn = document.getElementById('theme-toggle');
      const darkIcon = document.getElementById('theme-toggle-dark-icon');
      const lightIcon = document.getElementById('theme-toggle-light-icon');

      // Initialize theme icons
      if (document.documentElement.classList.contains('dark')) {
        lightIcon.classList.remove('hidden');
      } else {
        darkIcon.classList.remove('hidden');
      }

      // Theme toggle handler
      themeToggleBtn.addEventListener('click', () => {
        darkIcon.classList.toggle('hidden');
        lightIcon.classList.toggle('hidden');
        document.documentElement.classList.toggle('dark');
      });

      // Accordion toggle behavior
      faqItems.forEach(item => {
        const header = item.querySelector('.accordion-header');
        const content = item.querySelector('.accordion-content');

        header.addEventListener('click', () => {
          const isOpen = content.classList.contains('is-open');

          // If in single mode, close all other items first
          if (!allowMultiple && !isOpen) {
            faqItems.forEach(otherItem => {
              const otherContent = otherItem.querySelector('.accordion-content');
              otherContent.classList.remove('is-open');
            });
          }

          // Toggle current item
          const isCurrentlyOpen = content.classList.contains('is-open');

          // If in single mode, close all items first
          if (!allowMultiple) {
            faqItems.forEach(otherItem => {
              otherItem.classList.remove('is-active');
              otherItem.querySelector('.accordion-content').classList.remove('is-open');
            });
          }

          // Toggle state
          if (!isCurrentlyOpen) {
            item.classList.add('is-active');
            content.classList.add('is-open');
          } else {
            item.classList.remove('is-active');
            content.classList.remove('is-open');
          }
        });
      });

      // Toggle Multi vs Single expand mode
      modeBtn.addEventListener('click', () => {
        allowMultiple = !allowMultiple;
        if (allowMultiple) {
          modeIndicator.classList.replace('bg-amber-500', 'bg-emerald-500');
          modeLabel.textContent = 'Multi Open Mode';
        } else {
          modeIndicator.classList.replace('bg-emerald-500', 'bg-amber-500');
          modeLabel.textContent = 'Single Open Mode';

          // Keep at most 1 item open when switching back to single mode
          let firstFound = false;
          faqItems.forEach(item => {
            const content = item.querySelector('.accordion-content');
            if (content.classList.contains('is-open')) {
              if (firstFound) {
                item.classList.remove('is-active');
                content.classList.remove('is-open');
              } else {
                firstFound = true;
              }
            }
          });
        }
      });

      // Live Filter / Search Functionality
      searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        let visibleCount = 0;

        faqItems.forEach(item => {
          const text = item.textContent.toLowerCase();
          if (text.includes(query)) {
            item.style.display = 'block';
            visibleCount++;
          } else {
            item.style.display = 'none';
          }
        });

        noResults.classList.toggle('hidden', visibleCount > 0);
      });
    });
  </script>

</body>
</html>
    
@endsection
