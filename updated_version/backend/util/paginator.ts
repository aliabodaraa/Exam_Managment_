import { Model, ModelStatic, Op } from "sequelize";
export const ITEMS_PER_PAGE = 5;

export const getModelDataWithPagination = async <
    T extends ModelStatic<Model<any, any>>
>(
    model: T,
    current_page: number,
    included_deps: string[],
    iterms_per_page = ITEMS_PER_PAGE,
    term: string = "",
    search_mode: boolean = false
) => {
    iterms_per_page = !search_mode ? iterms_per_page : ITEMS_PER_PAGE;
    current_page = !search_mode ? current_page : 1;
    let offset = !search_mode ? getOffset(current_page, iterms_per_page) : 0;

    var { data, data_count } = await DBQuery<T>(
        model,
        iterms_per_page,
        offset,
        included_deps,
        term
    );
    console.log(data_count, "data_count---");
    if (iterms_per_page > data_count) iterms_per_page = data_count;

    const last_page = Math.ceil(data_count / iterms_per_page);

    if (last_page < current_page) {
        //this section for the case when we change the value of the slecet `items_per_page` and the value of last_page is less than the current_page value the we need a new render
        //we use setInterval to consider the network delay case with retrying process logic
        current_page = last_page;
        offset = getOffset(last_page, iterms_per_page);
        var { data, data_count } = await DBQuery(
            model,
            iterms_per_page,
            offset,
            included_deps,
            term
        );
    }

    let { next_page, has_next, has_previous, previous_page } =
        getPaginatorAction(data_count, current_page, iterms_per_page);
    let paginator_length = getPaginatorLength(data_count);

    return {
        data,
        data_count,
        has_next,
        has_previous,
        next_page,
        previous_page,
        last_page,
        current_page,
        iterms_per_page,
        paginator_length,
    };
};

function getPaginatorAction(
    data_count: number,
    current_page: number,
    iterms_per_page: number
) {
    // const offset_end = current_page * iterms_per_page;
    const has_next = iterms_per_page * current_page < data_count;
    // const remaining_items = has_next ? data_count - offset_end : 0;
    const has_previous = current_page > 1;
    const next_page = current_page + 1;
    const previous_page = current_page - 1;
    return { next_page, has_next, has_previous, previous_page };
}

function getOffset(page: number, iterms_per_page: number) {
    return (page - 1) * iterms_per_page;
}

async function DBQuery<T extends ModelStatic<Model<any, any>>>(
    model: T,
    iterms_per_page: number,
    offset: number,
    included_deps: string[],
    term: string = ""
) {
    let conditions: any = {};
    let rawAttributes = Object.keys(model.getAttributes()).filter(
        (x) => x !== "id"
    );
    rawAttributes.forEach((x: string) => {
        conditions[x] = { [Op.like]: `%${term}%` };
    });
    console.log("rawAttributes", conditions);
    let { rows, count } = await model.findAndCountAll({
        limit: iterms_per_page,
        offset: offset,
        include: included_deps,
        where: {
            username: { [Op.like]: `%${term}%` },
        },
    });
    console.log("structure", conditions);

    return { data: rows, data_count: count };
}

function getPaginatorLength(data_count: number) {
    let paginator_length = data_count;
    while (paginator_length >= 10) {
        paginator_length /= 2;
    }
    paginator_length = paginator_length > 0 ? Math.floor(paginator_length) : 0;
    return paginator_length;
}
