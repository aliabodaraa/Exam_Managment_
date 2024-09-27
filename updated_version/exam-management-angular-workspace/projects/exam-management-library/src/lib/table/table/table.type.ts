export type EmittedPaginatorValueType = {
  pageIndex: number;
  itermsPerPage?: number;
  term?: string;
  searchMode?: boolean;
};
export type IncomingDataTableType={data:any[],data_count:number,has_next:boolean,has_previous:boolean,last_page:number,next_page:number,previous_page:number,current_page:number,iterms_per_page:number,paginator_length:number}

export type Langs = 'ar' | 'en';
