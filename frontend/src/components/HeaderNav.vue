<template>
	<div class="card relative z-2">
		<Menubar :model="items">
			<template #start>
				<router-link to="/home/0">
					<img
						alt="logo"
						src="@/assets/images/general/logo-corto-azul.svg"
						height="40"
						class="mr-2"
					/>
				</router-link>
			</template>
			<template #end>
				<div class="btn-group">
					<button
						class="btn btn-secondary dropdown-toggle"
						type="button"
						data-bs-toggle="dropdown"
						aria-expanded="false"
					>
						{{ datos_sesion.usuario }}
					</button>
					<ul class="dropdown-menu">
						<li>
							<router-link class="dropdown-item" to="/login">Salir</router-link>
						</li>
					</ul>
				</div>
			</template>
		</Menubar>
	</div>
</template>

<script>
import { useStorage } from "vue3-storage";
import Menubar from "primevue/menubar";
import Button from "primevue/button";
import Avatar from "primevue/avatar";
export default {
	setup() {
		return { storage: useStorage() };
	},
	components: {
		Menubar,
		Button,
		Avatar,
	},
	data() {
		return {
			datos_sesion: this.storage.getStorageSync("datos_sesion"),
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
								{
									label: "Permisos",
									to: "/man/usu/permisos",
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