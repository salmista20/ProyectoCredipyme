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
					visible: this.ValidarModulo("USUARIOS"),
					items: [
						{
							label: "Gestión",
							to: "/usu/gestion",
							visible: this.ValidarSubmodulo("USUARIOS/GESTION"),
						},
						{
							label: "Permisos",
							to: "/usu/permisos",
							visible: this.ValidarSubmodulo("USUARIOS/PERMISOS"),
						},
					],
				},
				{
					label: "Clientes",
					icon: "pi pi-briefcase",
					visible: this.ValidarModulo("CLIENTES"),
					items: [
						{
							label: "Gestión",
							to: "/cli/gestion",
							visible: this.ValidarSubmodulo("CLIENTES/GESTION"),
						},
					],
				},
				{
					label: "Mantenimiento",
					icon: "pi pi-fw pi-cog",
					visible: this.ValidarModulo("MANTENIMIENTO"),
					items: [
						{
							label: "Usuarios",
							visible: this.ValidarModulo("MANTENIMIENTO/USUARIOS"),
							items: [
								{
									label: "Cargos",
									to: "/man/usu/cargos",
									visible: this.ValidarSubmodulo(
										"MANTENIMIENTO/USUARIOS_CARGOS"
									),
								},
								{
									label: "Agencias",
									to: "/man/usu/agencias",
									visible: this.ValidarSubmodulo(
										"MANTENIMIENTO/USUARIOS_AGENCIAS"
									),
								},
								{
									label: "Permisos",
									to: "/man/usu/permisos",
									visible: this.ValidarSubmodulo(
										"MANTENIMIENTO/USUARIOS_PERMISOS"
									),
								},
							],
						},
						{
							label: "Créditos",
							visible: this.ValidarModulo("MANTENIMIENTO/CREDITOS"),
							items: [
								{
									label: "Sectores",
									to: "/man/cre/sectores",
									visible: this.ValidarSubmodulo(
										"MANTENIMIENTO/CREDITOS_SECTORES"
									),
								},
								{ label: "Productos" },
								{ label: "Tipos" },
								{
									label: "Estados",
									to: "/man/cre/estados",
									visible: this.ValidarSubmodulo(
										"MANTENIMIENTO/CREDITOS_ESTADOS"
									),
								},
							],
						},
					],
				},
			],
			// items: [],
		};
	},

	methods: {
		ValidarModulo(modulo) {
			return (
				this.storage
					.getStorageSync("permisos")
					.filter((item) => item.includes(modulo)).length > 0
			);
		},
		ValidarSubmodulo(submodulo) {
			return this.storage.getStorageSync("permisos").includes(submodulo);
		},
	},
};
</script>

<style>
</style>