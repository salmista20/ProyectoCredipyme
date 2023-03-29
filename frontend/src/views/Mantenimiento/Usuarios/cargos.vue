<template>
	<div>
		<HeaderNav />
		<div class="main-content">
			<div class="layout-px-spacing dash_1 slot-mantenimiento-cargos">
				<div class="row layout-top-spacing">
					<div class="layout-spacing">
						<div class="card component-card_1">
							<headerClose
								:title="'LISTA DE CARGOS'"
								:area="'MANTENIMIENTO'"
							></headerClose>
							<h5 class="card-title">LISTA DE RESULTADOS</h5>
							<div class="card-body">
								<div class="row mb-2 col-12">
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
									:value="cargos"
									:scrollable="true"
									scrollHeight="450px"
									scrollDirection="both"
									:filters="filters"
									:globalFilterFields="['cargo']"
									:paginator="false"
									currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registro(s)"
								>
									<Column
										class="align-center"
										field="editar"
										header="EDITAR"
										style="width: 50px !important"
									>
										<template #body="{ data }">
											<div class="btn-group" role="group">
												<button
													class="btn btn-main-1 btn-sm"
													@click="Editar(data)"
												>
													<i class="pi pi-pencil"></i>
												</button>
											</div>
										</template>
									</Column>
									<Column
										class="align-center"
										field="cargo"
										header="CARGO"
										style="width: 200px !important"
									>
										<template #body="{ data }">
											{{ data.cargo }}
										</template>
									</Column>
									<Column
										field="habilitado"
										header="HABILITADO"
										style="width: 50px !important"
									>
										<template #body="{ data }">
											{{ data.habilitado == 1 ? "SI" : "NO" }}
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
const api_url = import.meta.env.VITE_API_URL;
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

			cargos: [],
		};
	},
	created() {
		this.filters = {
			global: { value: null, matchMode: FilterMatchMode.CONTAINS },
			agencia: { value: null, matchMode: FilterMatchMode.CONTAINS },
		};
	},
	mounted() {
		this.ListarRecursos();
	},

	methods: {
		async ListarRecursos() {
			let self = this;
			return await axios
				.get(api_url + "/man/usu/cargos/listar_recursos")
				.then(function (response) {
					self.cargos = response.data.cargos;
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
.slot-mantenimiento-cargos {
	width: 50% !important;
	margin-left: 25% !important;
}

@media (max-width: 992px) {
	.slot-mantenimiento-cargos {
		width: 98% !important;
		margin-left: 1% !important;
	}
}
</style>
