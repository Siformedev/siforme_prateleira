class Comissao extends Comun {
    constructor() {
        super();
    }
    datatable2(reference) {
        Comun.datatable(reference);
    }
    datatable(reference, display = 25) {
        super.datatable(reference, display);
    }
    print(element) {
        super.print(element);
    }
}
var comissao = new Comissao();