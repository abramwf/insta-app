<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
const page = usePage()
const username = computed(() => page.url.replace('/@', ''))
const isActive = computed(() => {
    const loggedInUser = page.props.auth.user?.username
    return username.value === loggedInUser && page.component === 'Profile'
})
</script>

<template>
    <div>
        <nav class="fixed left-0 right-0 bg-white shadow z-40">
            <div class="container px-6 py-4 mx-auto md:flex md:justify-between md:items-center">
                <div class="flex items-center justify-between">
                    <Link :href="route('home')">
                    <h1 class="font-semibold text-2xl"><span
                            class="border-b-2 py-0.5 pr-1 border-blue-800 text-blue-700 italic">Insta</span><span
                            class="font-normal text-3xl text-blue-800">/</span><span
                            class="border-t-2 py-0.5 pl-1 border-blue-800 text-blue-700 italic">App</span></h1>
                    </Link>
                </div>

                <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
                <div
                    class="gap-x-9 inset-x-0 w-full px-6 py-4 transition-all duration-300 ease-in-out bg-white  md:mt-0 md:p-0 md:top-0 md:relative md:bg-transparent md:w-auto md:opacity-100 md:translate-x-0 md:flex md:items-center">
                    <div class="flex flex-col md:items-center md:flex-row md:mx-6">
                        <Link class="my-2 transition-colors duration-300 transform font-medium md:mx-4 md:my-0"
                            :href="route('home')" :class="$page.component == 'Home' ? 'text-blue-500' : 'text-gray-700'
                                ">Home</Link>
                        <Link class="my-2 transition-colors duration-300 transform font-medium md:mx-4 md:my-0"
                            :href="route('user.index', $page.props.auth.user.username)" :class="isActive
                                ? 'text-blue-500'
                                : 'text-gray-700'">
                        Profile</Link>
                        <Link class="my-2 transition-colors duration-300 transform font-medium md:mx-4 md:my-0"
                            :href="route('post.create')" :class="$page.component == 'Post' ? 'text-blue-500' : 'text-gray-700'
                                ">Post</Link>
                        <div href="" class="flex items-center gap-x-2">
                            <img v-if="$page.props.auth.user.avatar" class="object-cover w-8 h-8 rounded-full"
                                :src="'storage/' + $page.props.auth.user.avatar" alt="">
                            <img v-else class="object-cover w-8 h-8 rounded-full" :src="'storage/default.png'" alt="">
                            <div>
                                <h1 class="text-base font-semibold text-gray-700">{{
                                    $page.props.auth.user.username }}
                                </h1>
                                <p class="text-xs text-gray-500 ">{{ $page.props.auth.user.email }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center md:block">
                        <Link
                            class="relative cursor-pointer text-red-900 transition-colors duration-300 transform font-medium  hover:text-red-800 "
                            :href="route('logout')" method="post" as="button" type="button">
                        Logout
                        </Link>
                    </div>
                </div>
            </div>
        </nav>
        <main class="pt-20 pb-6 px-8 flex w-ful justify-center">
            <slot />
        </main>
    </div>
</template>
