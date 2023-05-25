<template>
	<div class="card-header d-flex align-items-center justify-content-between">
		<strong>{{ title }}</strong>
		<router-link to="/home/0" style="float: right !important">
			<button
				type="button"
				class="btn btn-main-1 btn-sm rounded-circle"
				id="btn-close"
			>
				<i class="pi pi-times"></i>
			</button>
		</router-link>
	</div>
</template>

<script>
export default {
	props: {
		title: String,
	},
};
</script>

<style lang="scss">
</style>
