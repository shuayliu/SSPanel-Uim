<?php

declare(strict_types=1);

namespace App\Controllers\Node;

use App\Controllers\BaseController;
use App\Models\BlockIp;
use App\Models\DetectRule;
use App\Models\Node;
use App\Models\UnblockIp;
use App\Utils\ResponseHelper;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class FuncController extends BaseController
{
    /**
     * @param array     $args
     */
    public function ping(Request $request, Response $response, array $args)
    {
        $res = [
            'ret' => 1,
            'data' => 'pong',
        ];
        return $response->withJson($res);
    }

    /**
     * @param array     $args
     */
    public function getDetectLogs(Request $request, Response $response, array $args): ResponseInterface
    {
        $rules = DetectRule::all();

        return ResponseHelper::etagJson($request, $response, [
            'ret' => 1,
            'data' => $rules,
        ]);
    }

    /**
     * @param array     $args
     */
    public function getBlockip(Request $request, Response $response, array $args): ResponseInterface
    {
        $block_ips = BlockIp::Where('datetime', '>', \time() - 60)->get();

        return ResponseHelper::etagJson($request, $response, [
            'ret' => 1,
            'data' => $block_ips,
        ]);
    }

    /**
     * @param array     $args
     */
    public function getUnblockip(Request $request, Response $response, array $args): ResponseInterface
    {
        $unblock_ips = UnblockIp::Where('datetime', '>', \time() - 60)->get();

        return ResponseHelper::etagJson($request, $response, [
            'ret' => 1,
            'data' => $unblock_ips,
        ]);
    }

    /**
     * @param array     $args
     */
    public function addBlockIp(Request $request, Response $response, array $args)
    {
        $params = $request->getQueryParams();

        $data = $request->getParam('data');
        $node_id = $params['node_id'];
        $node = Node::find($node_id);
        if ($node === null) {
            return $response->withJson([
                'ret' => 0,
            ]);
        }

        if (count($data) > 0) {
            foreach ($data as $log) {
                $ip = $log['ip'];

                $exist_ip = BlockIp::where('ip', $ip)->first();
                if ($exist_ip !== null) {
                    continue;
                }

                // log
                $ip_block = new BlockIp();
                $ip_block->ip = $ip;
                $ip_block->nodeid = $node_id;
                $ip_block->datetime = \time();
                $ip_block->save();
            }
        }

        $res = [
            'ret' => 1,
            'data' => 'ok',
        ];
        return $response->withJson($res);
    }
}
