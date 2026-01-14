@extends('base')
@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="mx-auto max-w-5xl">
        
        <!-- Header -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="p-8 text-white" style="background: linear-gradient(135deg, #293358 0%, #293358 100%);">
                <h1 class="text-4xl font-bold mb-2">À propos du Projet</h1>
                <p class="text-blue-100 text-lg">
                    Solution de suivi de colis développée au département Informatique de l'IUT
                </p>
            </div>

            <!-- Contenu -->
            <div class="p-8 space-y-8">
                
                <!-- Notre Équipe -->
                <section>
                    <div class="flex items-center mb-4">
                        <div class="w-1 h-8 rounded mr-3" style="background-color: #293358;"></div>
                        <h2 class="text-2xl font-bold text-gray-800">Notre Équipe</h2>
                    </div>
                    
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <p class="text-gray-700 leading-relaxed mb-3">
                            Nous sommes une équipe de <strong style="color: #293358;">six étudiants passionnés</strong> en BUT2 Informatique à l'IUT de Villetaneuse. Unis par notre intérêt commun pour le développement web et la gestion de projets, nous collaborons étroitement pour concevoir des solutions techniques innovantes et performantes.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            Notre équipe combine des compétences variées en développement backend avec Laravel, design d'interfaces utilisateur, et gestion de bases de données. Cette diversité de talents nous permet d'aborder chaque aspect du projet avec expertise et créativité.
                        </p>
                    </div>
                </section>

                <hr class="border-gray-200">

                <!-- Objectif du Projet -->
                <section>
                    <div class="flex items-center mb-4">
                        <div class="w-1 h-8 rounded mr-3" style="background-color: #293358;"></div>
                        <h2 class="text-2xl font-bold text-gray-800">Objectif du Projet</h2>
                    </div>
                    
                    <p class="text-gray-700 leading-relaxed mb-6">
                        Ce projet SAE vise à développer une <strong style="color: #293358;">plateforme complète de gestion et de suivi de colis</strong> destinée à optimiser les interactions entre les fournisseurs externes et l'IUT de Villetaneuse.
                    </p>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="bg-white p-5 rounded-lg shadow border-l-4" style="border-color: #293358;">
                            <h3 class="font-bold text-gray-800 mb-2">📦 Suivi en temps réel</h3>
                            <p class="text-gray-600 text-sm">
                                Assurer une visibilité totale sur l'acheminement de chaque colis, de l'expédition à la réception finale.
                            </p>
                        </div>
                        
                        <div class="bg-white p-5 rounded-lg shadow border-l-4" style="border-color: #293358;">
                            <h3 class="font-bold text-gray-800 mb-2">🔄 Gestion simplifiée</h3>
                            <p class="text-gray-600 text-sm">
                                Centraliser et simplifier la gestion des commandes pour tous les acteurs impliqués.
                            </p>
                        </div>
                        
                        <div class="bg-white p-5 rounded-lg shadow border-l-4" style="border-color: #293358;">
                            <h3 class="font-bold text-gray-800 mb-2">👥 Interface intuitive</h3>
                            <p class="text-gray-600 text-sm">
                                Offrir une expérience utilisateur fluide et accessible à tous les profils d'utilisateurs.
                            </p>
                        </div>
                        
                        <div class="bg-white p-5 rounded-lg shadow border-l-4" style="border-color: #293358;">
                            <h3 class="font-bold text-gray-800 mb-2">🎯 Solution professionnelle</h3>
                            <p class="text-gray-600 text-sm">
                                Développer un outil robuste répondant aux exigences d'un environnement professionnel.
                            </p>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-5 text-center border-t">
                <p class="text-sm font-semibold text-gray-700">BUT2 Informatique - IUT de Villetaneuse</p>
                <p class="text-xs text-gray-500 mt-1">Projet SAE - Suivi de Colis • 2024-2025</p>
            </div>
        </div>
    </div>
</div>
@endsection