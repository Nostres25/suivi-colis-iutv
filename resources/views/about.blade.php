@extends('base')

@section('header')
    <div class="container d-block">
        <h1 class="h1">À propos du projet</h1>
        <p class="mb-0 opacity-75">Solution de suivi de colis développée au département Informatique de l'IUT à Villetaneuse</p>
    </div>
@endsection

@section('content')


    {{-- TODO Écrire un vrai contenu qui présente réellement le projet (notamment choix de reflexions etc...) et l'équipe OU supprimer la page mais pas du texte en IA ça ne sert à rien--}}
    {{-- TODO Créditer chaque membre des l'équipe --}}

    <!-- Contenu -->
    <!-- Objectif du Projet -->
    <section class="mt-4">
        <div class="flex items-center mb-4">
            <div class="w-1 h-8 rounded mr-3" style="background-color: #3170A8;"></div>
            <h2 class="text-2xl font-bold text-gray-800">Objectif du Projet</h2>
        </div>

        <p class="text-gray-700 leading-relaxed mb-6">
            Ce projet SAE vise à développer une <strong style="color: #3170A8;">plateforme complète de gestion et de suivi de colis</strong> destinée à optimiser les interactions entre les fournisseurs externes et l'IUT de Villetaneuse.
        </p>

        <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-white p-5 rounded-lg shadow border-l-4" style="border-color: #3170A8;">
                <h3 class="font-bold text-gray-800 mb-2">📦 Suivi en temps réel</h3>
                <p class="text-gray-600 text-sm">
                    Assurer une visibilité totale sur l'acheminement de chaque colis, de l'expédition à la réception finale.
                </p>
            </div>

            <div class="bg-white p-5 rounded-lg shadow border-l-4" style="border-color: #3170A8;">
                <h3 class="font-bold text-gray-800 mb-2">🔄 Gestion simplifiée</h3>
                <p class="text-gray-600 text-sm">
                    Centraliser et simplifier la gestion des commandes pour tous les acteurs impliqués.
                </p>
            </div>

            <div class="bg-white p-5 rounded-lg shadow border-l-4" style="border-color: #3170A8;">
                <h3 class="font-bold text-gray-800 mb-2">👥 Interface intuitive</h3>
                <p class="text-gray-600 text-sm">
                    Offrir une expérience utilisateur fluide et accessible à tous les profils d'utilisateurs.
                </p>
            </div>

            <div class="bg-white p-5 rounded-lg shadow border-l-4" style="border-color: #3170A8;">
                <h3 class="font-bold text-gray-800 mb-2">🎯 Solution professionnelle</h3>
                <p class="text-gray-600 text-sm">
                    Développer un outil robuste répondant aux exigences d'un environnement professionnel.
                </p>
            </div>
        </div>
    </section>

    <!-- Équipe -->
    <section>
        <div class="flex items-center mb-4">
            <div class="w-1 h-8 rounded mr-3" style="background-color: #3170A8;"></div>
            <h2 class="text-2xl font-bold text-gray-800">Notre Équipe</h2>
        </div>

        <div class="bg-blue-50 p-6 rounded-lg">
            <p class="text-gray-700 leading-relaxed mb-3">
                Nous sommes une équipe de <strong style="color: #3170A8;">six étudiants passionnés</strong> en BUT2 Informatique à l'IUT de Villetaneuse. Unis par notre intérêt commun pour le développement web et la gestion de projets, nous collaborons étroitement pour concevoir des solutions techniques innovantes et performantes.
            </p>
            <p class="text-gray-700 leading-relaxed">
                Notre équipe combine des compétences variées en développement backend avec Laravel, design d'interfaces utilisateur, et gestion de bases de données. Cette diversité de talents nous permet d'aborder chaque aspect du projet avec expertise et créativité.
            </p>
        </div>
    </section>
@endsection
