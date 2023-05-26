<template>
	<div>
		<HeaderNav />
		<div class="main-content">
			<div class="layout-px-spacing dash_1 slot-usuarios-permisos">
				<div class="row layout-top-spacing">
					<div class="layout-spacing">
						<div class="card component-card_1">
							<HeaderClose
								:title="'LISTA DE USUARIOS'"
								:area="'MANTENIMIENTO'"
							></HeaderClose>
							<h5 class="card-title">PANEL DE BÚSQUEDA</h5>
							<div class="card-body">
								<div class="row justify-content-center">
									<div class="form-group col-md-4 col-6">
										<div class="input-group">
											<span class="input-group-text">AGENCIA</span>
											<select
												class="form-select text-center"
												v-model="filtros_usuarios['agencia'].value"
											>
												<option :value="null" selected>TODAS</option>
												<option v-for="(item, index) in agencias" :key="index">
													{{ item.agencia }}
												</option>
											</select>
										</div>
									</div>
									<div class="form-group col-md-5 col-6">
										<div class="input-group">
											<span class="input-group-text">Cargo </span>
											<select
												class="form-select"
												v-model="filtros_usuarios['cargo'].value"
											>
												<option :value="null" selected>TODOS</option>
												<option
													v-for="(item, index) in cargos"
													:key="index"
													:value="item.id"
												>
													{{ item.cargo }}
												</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<h5 class="card-title">LISTA DE RESULTADOS</h5>
							<div class="card-body">
								<div class="row justify-content-md-center mb-2 col-12">
									<div class="form-group col-md-6 col-9"></div>
								</div>

								<DataTable
									:value="usuarios"
									:scrollable="true"
									scrollHeight="400px"
									scrollDirection="both"
									:filters="filtros_usuarios"
									:paginator="true"
									:rows="20"
									paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport"
									currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registro(s)"
								>
									<Column
										class="align-center"
										field="editar"
										header="EDITAR"
										style="width: 80px"
									>
										<template #body="{ data }">
											<button
												class="btn btn-main-2 btn-sm"
												@click="Editar(data)"
											>
												<i class="pi pi-check-square"></i>
											</button>
										</template>
									</Column>
									<Column
										class="align-center"
										field="agencia"
										header="AGENCIA"
										style="width: 120px"
									>
										<template #body="{ data }">
											{{ data.agencia }}
										</template>
									</Column>
									<Column
										class="align-center"
										field="usuario"
										header="USUARIO"
										style="width: 100px"
									>
										<template #body="{ data }">
											{{ data.usuario }}
										</template>
									</Column>
									<Column
										field="colaborador"
										header="COLABORADOR"
										style="width: 250px"
									>
										<template #body="{ data }">
											{{ data.colaborador }}
										</template>
									</Column>
									<Column field="cargo" header="CARGO" style="width: 250px">
										<template #body="{ data }">
											{{ data.cargo }}
										</template>
									</Column>
								</DataTable>
							</div>
						</div>
					</div>
				</div>
			</div>
			<MdlEditarPermisos
				ref="mdlEditarPermisos"
				:agencias="agencias"
				:usuarios="usuarios"
				:cargos="cargos"
			></MdlEditarPermisos>
		</div>
	</div>
</template>

<script>
// Libreria VUE-STORAGE
import { useStorage } from "vue3-storage";

// Componentes del proyecto
import HeaderNav from "@/components/HeaderNav.vue";
import HeaderClose from "@/components/HeaderClose.vue";
import MdlEditarPermisos from "@/views/Usuarios/Components/mdlEditarPermisos.vue";

// Libreria PRIMEVUE - DATATABLE
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import { FilterMatchMode } from "primevue/api";

const api_url = import.meta.env.VITE_API_URL;

export default {
	setup() {
		return { storage: useStorage() };
	},
	components: {
		HeaderNav,
		HeaderClose,
		MdlEditarPermisos,

		DataTable,
		Column,
		Dialog,
		Button,
	},
	data() {
		return {
			cargos: [],
			usuarios: [],
			filtros_usuarios: {},
		};
	},
	computed: {
		agencias() {
			return this.storage.getStorageSync("agencias");
		},
	},

	created() {
		this.filtros_usuarios = {
			global: { value: null, matchMode: FilterMatchMode.CONTAINS },
			agencia: { value: null, matchMode: FilterMatchMode.CONTAINS },
			cargo: { value: null, matchMode: FilterMatchMode.CONTAINS },
		};
	},
	mounted() {
		this.ListarRecursos();
	},

	methods: {
		async ListarRecursos() {
			let self = this;
			return await axios
				.get(api_url + "/usu/permisos/listar_recursos")
				.then(function (response) {
					self.cargos = response.data.cargos;
					self.usuarios = response.data.usuarios;
				});
		},
		FiltrarUsuarios(e) {
			let agencia_id = e.target.value;

			this.usuario_seleccionado = 0;
			if (agencia_id == 0) {
				this.usuarios_filtrados = [];
			} else {
				this.usuarios_filtrados = this.usuarios.filter(
					(item) => item.agencia_id == agencia_id
				);
			}
		},

		async Editar(item) {
			let mdlEditarPermisos = this.$refs.mdlEditarPermisos;

			mdlEditarPermisos.frmDatosUsuario.id = item.id;
			mdlEditarPermisos.frmDatosUsuario.colaborador = item.colaborador;
			mdlEditarPermisos.frmDatosUsuario.agencia = item.agencia;
			mdlEditarPermisos.frmDatosUsuario.cargo = item.cargo;
			mdlEditarPermisos.tipo_asignacion = null;

			await mdlEditarPermisos.ListarPermisos();

			mdlEditarPermisos.modal_visible = true;
		},
	},
};
</script>

<style lang="scss">
.slot-usuarios-permisos {
	width: 50% !important;
	margin-left: 25% !important;
}

.mdlDatosEstado {
	width: 30%;
}

@media (max-width: 992px) {
	.slot-usuarios-permisos {
		width: 80% !important;
		margin-left: 10% !important;
	}

	.mdlDatosEstado {
		width: 40%;
	}
}

@media (max-width: 400px) {
	.slot-usuarios-permisos {
		width: 98% !important;
		margin-left: 1% !important;
	}

	.mdlDatosEstado {
		width: 80%;
	}
}
</style>
