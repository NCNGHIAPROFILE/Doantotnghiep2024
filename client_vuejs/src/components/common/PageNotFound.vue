<template>
    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>Oops!</h1>
                <h2>404 - The Page can't be found</h2>
            </div>
            <a data-bcup-haslogintext="no" @click="handleClick">Go TO Homepage</a>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        handleClick() {
            this.$router.push({ name: 'Login' });
        }
    }
}
</script>

<style src="./PageNotFound.scss" lang="scss" />
