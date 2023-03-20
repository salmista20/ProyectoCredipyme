<template>
	<div>
		<HeaderNav />
		<div class="main-content">
			<div class="layout-px-spacing dash_1 slot-usuarios-gestion">
				<div class="row layout-top-spacing">
					<div class="layout-spacing">
						<div class="card component-card_1">
							<headerClose
								:title="'GESTIÓN DE USUARIOS'"
								:area="'GTH'"
							></headerClose>
							<h5 class="card-title">LISTA DE RESULTADOS</h5>
							<div class="card-body">
								<div class="row mb-2 col-12">
									<div class="col-md-4 col-9">
										<div class="input-group">
											<span class="input-group-text"> AGENCIA </span>
											<select
												v-model="filters['agencia'].value"
												class="form-select text-center"
											>
												<option :value="null" selected>TODAS</option>
												<option
													v-for="item in agencias"
													:key="item.id"
													:value="item.agencia"
												>
													{{ item.agencia }}
												</option>
											</select>
										</div>
									</div>
									<div class="col-md-5 col-9">
										<div class="input-group">
											<span class="input-group-text">
												<i class="pi pi-search"></i>
											</span>
											<input
												v-model="filters['global'].value"
												class="form-control mayus"
												type="text"
												placeholder="Buscar..."
												autocomplete="off"
												spellcheck="false"
											/>
										</div>
									</div>

									<div class="col-md-3 col-3">
										<button
											type="button"
											class="btn btn-main-1 btn-icon-split"
											@click="Nuevo"
										>
											<i class="pi pi-plus"></i>
											<span class="text">NUEVO</span>
										</button>
									</div>
								</div>
								<DataTable
									:value="usuarios"
									:scrollable="true"
									scrollHeight="450px"
									scrollDirection="both"
									:filters="filters"
									:globalFilterFields="['agencia', 'colaborador']"
									:paginator="true"
									:rows="20"
									paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport"
									currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registro(s)"
								>
									<Column
										class="align-center"
										field="acciones"
										header="ACCIONES"
										style="width: 100px !important"
									>
										<template #body="{ data }">
											<div class="btn-group" role="group">
												<button
													class="btn btn-main-1 btn-sm"
													@click="Editar(data)"
												>
													<i class="pi pi-pencil"></i>
												</button>
												<button
													class="btn btn-main-2 btn-sm"
													@click="ModificarClave(data)"
												>
													<i class="pi pi-lock"></i>
												</button>
											</div>
										</template>
									</Column>
									<Column
										class="align-center"
										field="usuario"
										header="USUARIO"
										style="width: 150px !important"
									>
										<template #body="{ data }">
											{{ data.usuario }}
										</template>
									</Column>
									<Column
										field="trabajador"
										header="NOMBRE COMPLETO"
										style="width: 250px !important"
									>
										<template #body="{ data }">
											{{ data.colaborador }}
										</template>
									</Column>
									<Column
										class="align-center"
										field="dni"
										header="DNI"
										style="width: 100px !important"
									>
										<template #body="{ data }">
											{{ data.dni }}
										</template>
									</Column>
									<Column
										class="align-center"
										field="agencia"
										header="AGENCIA"
										style="width: 120px !important"
									>
										<template #body="{ data }">
											{{ data.agencia }}
										</template>
									</Column>

									<Column
										field="cargo"
										header="CARGO"
										style="width: 150px !important"
									>
										<template #body="{ data }">
											{{ data.cargo }}
										</template>
									</Column>
									<Column
										field="rol"
										header="ROL"
										style="width: 150px !important"
									>
										<template #body="{ data }">
											{{ data.rol }}
										</template>
									</Column>
								</DataTable>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { useStorage } from "vue3-storage";
import HeaderNav from "@/components/HeaderNav.vue";
import HeaderClose from "@/components/HeaderClose.vue";

import DataTable from "primevue/datatable";
import Column from "primevue/column";

import { FilterMatchMode } from "primevue/api";
export default {
	setup() {
		return { storage: useStorage() };
	},
	components: {
		HeaderNav,
		HeaderClose,

		DataTable,
		Column,
	},
	data() {
		return {
			filters: {},

			usuarios: [],
			departamentos: [],
			provincias: [],
			distritos: [],
			cargos: [],
			horarios: [],
			agencias: [],
		};
	},
	created() {
		this.filters = {
			global: { value: null, matchMode: FilterMatchMode.CONTAINS },
			agencia: { value: null, matchMode: FilterMatchMode.CONTAINS },
		};
	},
	mounted() {
		// this.ListarRecursos();
	},

	methods: {
		async ListarRecursos() {
			let self = this;
			return await axios
				.get(route("usu.gestion.listar"))
				.then(function (response) {
					self.usuarios = response.data.usuarios;
					self.departamentos = response.data.departamentos;
					self.provincias = response.data.provincias;
					self.distritos = response.data.distritos;
					self.cargos = response.data.cargos;
					self.horarios = response.data.horarios;
				});
		},
		Editar(item) {
			this.mdlDatosUsuario.active_tab = 0;
			this.mdlDatosUsuario.Editar(item);
		},
		Nuevo() {
			this.mdlDatosUsuario.active_tab = 0;
			this.mdlDatosUsuario.Nuevo();
		},
		ModificarClave(item) {
			this.mdlCambiarClave.Modificar(item);
		},
	},
};
</script>

<style lang="scss">
.slot-usuarios-gestion {
	width: 70% !important;
	margin-left: 15% !important;
}

@media (max-width: 992px) {
	.slot-usuarios-gestion {
		width: 98% !important;
		margin-left: 1% !important;
	}
}
</style>
