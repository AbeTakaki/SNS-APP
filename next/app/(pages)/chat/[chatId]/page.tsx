import Auth from "@/src/components/auth";
import MessagePostForm from "@/src/components/chat/messagepostform";
import { getMessages, getUserData } from "@/src/lib/actions";
import { errorRedirect } from "@/src/lib/navigations";
import React from "react";

type Props={
  params:Promise<{chatId:number}>;
};

export default async function Page({params}:Props) {
  let userId;
  try{
    const res = await getUserData();
    userId = res.id;
  }catch(e){
    await errorRedirect((e as Error & { statusCode?: number }).statusCode);
    throw new Error("予期せぬエラーが発生しました");
  }

  try{
    const res = await getMessages((await params).chatId);
    if(!res.messages){
      throw Object.assign(new Error(res),{statusCode:res.status});
    }
  }catch(e){
    await errorRedirect((e as Error & { statusCode?: number }).statusCode);
    throw new Error("予期せぬエラーが発生しました");
  }

  return(
    <>
      <Auth>
        <MessagePostForm userId={userId} chatId={(await params).chatId} />
      </Auth>
    </>
  );
}