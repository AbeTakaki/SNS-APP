import Auth from "@/src/components/auth";
import UpdateForm from "@/src/components/xweet/updateform";
import { canUpdateXweet } from "@/src/lib/actions";
import { errorRedirect } from "@/src/lib/navigations";
export const dynamic = 'force-dynamic';

type Props={
  params:Promise<{xweetId:number}>;
};

export default async function Page({params}:Props){
  let data;
  try{
    const res = await canUpdateXweet((await params).xweetId);
    data = res;
  }catch(e){
    await errorRedirect((e as Error & { statusCode?: number }).statusCode);
    throw new Error("予期せぬエラーが発生しました");
  }

  return(
    <>
      <Auth>
        <UpdateForm xweetId={data.id} content={data.content} />
      </Auth>
    </>
  )
}