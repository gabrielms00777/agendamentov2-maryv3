<!-- resources/views/landing.blade.php -->
<x-app-layout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-800 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Revolucione seus Agendamentos</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                Sistema completo de agendamento automatizado via WhatsApp para seu salão, clínica ou consultório
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <x-button label="Experimente Grátis" link="/register" icon="o-arrow-right" class="btn-primary btn-lg" />
                <x-button label="Ver Demonstração" link="/demo" icon="o-play-circle" class="btn-outline btn-lg text-white" />
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Recursos Incríveis</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <x-feature-card 
                    icon="o-chat-bubble-left-ellipsis" 
                    title="Agendamento via WhatsApp"
                    description="Seus clientes agendam diretamente pelo WhatsApp, sem complicação" />
                
                <x-feature-card 
                    icon="o-bell-alert" 
                    title="Lembretes Automáticos"
                    description="Reduza faltas com lembretes automáticos de confirmação" />
                
                <x-feature-card 
                    icon="o-chart-bar" 
                    title="Relatórios Poderosos"
                    description="Acompanhe seu faturamento e produtividade em tempo real" />
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Como Funciona</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <x-step-card 
                    step="1" 
                    title="Cadastre-se"
                    description="Crie sua conta em menos de 2 minutos" />
                
                <x-step-card 
                    step="2" 
                    title="Conecte seu WhatsApp"
                    description="Vincule seu número em poucos passos" />
                
                <x-step-card 
                    step="3" 
                    title="Comece a Agendar"
                    description="Pronto! Seus clientes já podem marcar horários" />
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Quem já usa recomenda</h2>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <x-testimonial-card 
                    name="Ana Silva"
                    role="Dona do Salão Bella Hair"
                    quote="Reduziu nossas faltas em 70% e melhorou muito a organização!"
                    avatar="https://randomuser.me/api/portraits/women/44.jpg" />
                
                <x-testimonial-card 
                    name="Carlos Souza"
                    role="Médico Dermatologista"
                    quote="O sistema salvou minha secretária de tanto trabalho manual!"
                    avatar="https://randomuser.me/api/portraits/men/32.jpg" />
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Pronto para transformar seu negócio?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Experimente gratuitamente por 14 dias. Sem necessidade de cartão de crédito.
            </p>
            <x-button label="Começar Agora" link="/register" icon="o-arrow-right" class="btn-primary btn-lg" />
        </div>
    </section>
</x-app-layout>