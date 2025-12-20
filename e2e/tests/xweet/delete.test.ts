import { test, expect } from '@playwright/test'
import { testCreateXweet, testCreateUser, testLogin } from '../utils';

let user:any;
let user2:any;
let xweet:any;

test.beforeEach(async ({ request }) => {
  await request.post(`${process.env.TEST_API_URL}/api/test/reset-db`);
  user = await testCreateUser();
  user2 = await testCreateUser();
  xweet = await testCreateXweet(user.id,'Test Xweet');
});

test.afterEach(async ({ page }) => {
  await page.close();
});

test('別ユーザでは、Xweet削除ボタンが表示されない', async ({ page }) => {
  await testLogin(page,user2.email,'password');
  await expect(page.locator('#xweet-delete')).toHaveCount(0);
});

test('ログイン後、Xweet削除しレスポンスが返る', async ({ page }) => {
  await testLogin(page,user.email,'password');
  await expect(page.locator('#xweet-content')).toContainText(['Test Xweet']);
  await expect(page.locator('#xweet-delete')).toHaveCount(1);
  await page.click('#xweet-delete');
  await page.locator('#xweet-content').waitFor({state:'detached'});
  await page.goto(`${process.env.TEST_FRONT_URL}/xweet`);
  await expect(page.locator('#xweet-content')).not.toContainText(['Test Xweet']);
});