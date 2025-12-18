import Auth from "@/src/components/auth";
import UpdateForm from "@/src/components/xweet/updateform";
import { canUpdateXweet } from "@/src/lib/actions";
import { redirect } from "next/navigation";

type Props={
  params:Promise<{xweetId:number}>;
};

export default async function Page({params}:Props){
  let data;
  try{
    const res = await canUpdateXweet((await params).xweetId);
    data = res;
  }catch(e){
    console.log((e as Error).message);
    redirect("/error/403");
  }

  return(
    <>
      <Auth>
        <UpdateForm xweetId={data.id} content={data.content} />
      </Auth>
    </>
  )
}