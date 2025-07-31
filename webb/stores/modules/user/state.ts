export interface State {
    isLoading: any;
    roles: string[];
    userEmail: string|null;
    token: string|null;
}

const state: State = {
    isLoading: false,
    // roles: [],
    // roles: ['ROLE_FREE_USER'],
    roles: ['ROLE_SUPER_ADMIN'],
    userEmail: null,
    token: "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MzM3NzU2MzksImV4cCI6MTczMzg2MjAzOSwicm9sZXMiOlsiUk9MRV9TVVBFUl9BRE1JTiJdLCJ1c2VybmFtZSI6InptYWN6b3dhbmlAem1hY3pvd2FuaS5kZXYifQ.GqqppCBUY0e2R9rvbjVEolAi92SK2lJyvirkMs4E480oxLMCJ9ckLjtTBh08TOSGvTLThNClof4Y9ZU3PMmVu7Sp3yKxUpINBS4IN8FLxvQHsJSEXvf5OK2vh7W4sq0fs87lUfUyAZIaZyxrNYbqS5QjNMvFEAc2p6IFKSMstw49H2Gbb9YnbyqjetjIbBspcG38BMSRbYiFyhENLMoVrfvhz1sL97QQ48tcKyxp4DGhJEO5u1R9M4kPEHEbNspi-m_qh1JN7mCQiLE1xR51AznIzqq0EAmqY8ld3D3LE7uFWju3ZZWD9IwX5M2ifqZoKp6A0d2EOantVj5tQGb8sQ",
    // token: null,
};

export default state;
