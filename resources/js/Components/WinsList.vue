<template>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ balance }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                баллов на счете
            </p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <Win v-for="win in wins" :key="win.id" :win="win"></Win>
            </dl>
        </div>
    </div>
</template>

<script>
    import Win from "@/Components/Win";

    export default {
        name: "WinsList",

        components: {Win},

        props: {
            balance: {
                type: Number,
                default: 0,
            },
        },

        data() {
            return {
                wins:[]
            }
        },

        mounted() {
            this.getWins()
        },

        methods: {
            getWins() {
                axios.get(this.route('wins.get'))
                    .then(response => {
                        this.wins = response.data.data
                    })
            }
        }
    }
</script>

<style scoped>

</style>
