<template>
	<div class="card relative z-2">
		<Menubar :model="items">
			<template #start>
				<img
					alt="logo"
					src="@/assets/images/general/logo-corto-azul.svg"
					height="40"
					class="mr-2"
				/>
			</template>
			<template #end>
				<router-link to="/login"
					><Button
						label="Cerrar sesión"
						severity="info"
						icon="pi pi-power-off"
						size="small"
						rounded
				/></router-link>
			</template>
		</Menubar>
	</div>
</template>

<script>
import Menubar from "primevue/menubar";
import Button from "primevue/button";
export default {
	components: {
		Menubar,
		Button,
	},
	data() {
		return {
			items: [
				{
					label: "Usuarios",
					icon: "pi pi-fw pi-user",
					items: [
						{
							label: "Gestión",
							to: "/usu/gestion",
						},
						{
							label: "Permisos",
						},
					],
				},
				{
					label: "Mantenimiento",
					icon: "pi pi-fw pi-cog",
					items: [
						{
							label: "Usuarios",
							items: [
								{
									label: "Cargos",
									to: "/man/usu/cargos",
								},
								{
									label: "Agencias",
									to: "/man/usu/agencias",
								},
							],
						},
						{
							label: "Créditos",
							items: [
								{ label: "Sectores", to: "/man/cre/sectores" },
								{ label: "Productos" },
								{ label: "Tipos" },
								{ label: "Estados", to: "/man/cre/estados" },
							],
						},
					],
				},
			],
		};
	},
};
</script>

<style>
</style>