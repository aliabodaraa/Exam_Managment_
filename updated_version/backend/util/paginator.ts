import { Model, ModelStatic } from "sequelize";
export const ITEMS_PER_PAGE = 5;

export const getDataWithPagination = async (
    model: ModelStatic<Model<any, any>>,
    current_page: number,
    included_deps: string[],
    iterms_per_page = ITEMS_PER_PAGE
) => {
    const offset = (current_page - 1) * iterms_per_page;

    const { rows: data, count: data_count } = await model.findAndCountAll({
        limit: iterms_per_page,
        offset: offset,
        include: included_deps,
    });
    const offset_end = current_page * iterms_per_page;

    const has_next = iterms_per_page * current_page < data_count;
    const remaining_items = has_next ? data_count - offset_end : 0;
    const has_previous = current_page > 1;
    const next_page = current_page + 1;
    const previous_page = current_page - 1;
    const last_page = Math.ceil(data_count / iterms_per_page);

    return {
        data,
        data_count,
        has_next,
        remaining_items,
        has_previous,
        next_page,
        previous_page,
        last_page,
        current_page,
        iterms_per_page,
    };
};
