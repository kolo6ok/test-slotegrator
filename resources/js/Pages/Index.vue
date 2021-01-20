<template>
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">

            <inertia-link v-if="$page.props.user" href="/wins" class="text-sm text-gray-700 underline">
                Ваши выигрыши
            </inertia-link>

            <template v-else>
                <inertia-link :href="route('login')" class="text-sm text-gray-700 underline">
                    Login
                </inertia-link>

                <inertia-link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </inertia-link>
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div v-if="$page.props.user"
                 class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg h-5/6 w-10/12">
                <Draw></Draw>
            </div>

            <div v-else
                 class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">

                <div class="grid grid-cols-1">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div>
                                Для того что бы играть войдите в свой профиль или зарегистрируйтесь.

                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center">

                            <inertia-link :href="route('login')" class="text-sm text-gray-700 underline">
                                Войти
                            </inertia-link>

                            <inertia-link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                                Зарегистрироваться
                            </inertia-link> </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</template>

<style scoped>

</style>

<script>
    import Draw from "@/Components/Draw";

    export default {
        components: {
          Draw
        },
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
        },
        data() {
            return {

            }
        }
    }
</script>
