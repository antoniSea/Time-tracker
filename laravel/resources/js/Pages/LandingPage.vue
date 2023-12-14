<template>
    <HeroSection />

    <FeaturesSection>
            <FeatureCard
                title="CSV file Generation"
                description="Our application allows you to generate csv files and send them to your clients"
            >
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                        <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </template>
            </FeatureCard>

            <FeatureCard
                title="Track every minute"
                description="Our application allows you to track every minute of your work"
            >
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">
                        <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z"/>
                        <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z"/>
                    </svg>
                </template>
            </FeatureCard>

            <FeatureCard
                title="Work with multiple clients"
                description="Our application allows you to work with multiple clients at the same time"
            >
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-file-earmark-person" viewBox="0 0 16 16">
                        <path d="M11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2v9.255S12 12 8 12s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h5.5v2z"/>
                    </svg>
                </template>
            </FeatureCard>
    </FeaturesSection>


    <TestamonialsSection>
        <TestamonialCard
            content="This service is incredible. It's easy to use, provides insightful data, and the customer support team is always willing to help. Highly recommended!"
            user-name="Samuel Lee"
        />

        <TestamonialCard
            content="This time tracking service has changed the way I work. I am now able to manage my time more effectively and complete projects ahead of schedule."
            user-name="Lisa Miller"
        />
    </TestamonialsSection>

    <div class="flex items-center justify-center py-16 bg-blue-500" id="start">
        <div class="text-center">
            <h2 class="text-3xl text-white font-bold mb-4">Start Tracking Your Time Today</h2>
            <Link class="px-6 py-3 text-blue-500 bg-white rounded" :href="route('register')">Sign Up for Free</Link>
        </div>
    </div>

    <ContactForm />

    <Footer />
</template>

<script setup>
import HeroSection from "../Components/LandingPage/HeroSection.vue";
import FeaturesSection from "../Components/LandingPage/FeaturesSection.vue";
import FeatureCard from "../Components/LandingPage/FeatureCard.vue";
import TestamonialsSection from "../Components/LandingPage/TestamonialsSection.vue";
import TestamonialCard from "../Components/LandingPage/TestamonialCard.vue";
import ContactForm from "../Components/ContactForm.vue";
import Footer from "../Components/LandingPage/Footer.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
    'user': Object,
});
</script>


<style>
    html {
        scroll-behavior: smooth;
    }
</style>
