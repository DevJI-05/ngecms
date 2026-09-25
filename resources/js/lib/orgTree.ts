export interface OrgTreeMember {
    id: number;
    name: string;
    role: string;
    level: number;
    initials: string;
    avatar_bg: string;
    avatar_color: string;
}

export interface OrgTreeNode {
    member: OrgTreeMember;
    children: OrgTreeNode[];
}

/**
 * Builds a nested tree from a flat, unordered list of members using
 * `parent_id`. Members whose `parent_id` is null, or points to a member not
 * present in the list, become roots.
 */
export function buildOrgTree(
    members: (OrgTreeMember & { parent_id: number | null })[],
): OrgTreeNode[] {
    const nodesById = new Map<number, OrgTreeNode>();
    members.forEach((member) => nodesById.set(member.id, { member, children: [] }));

    const roots: OrgTreeNode[] = [];

    members.forEach((member) => {
        const node = nodesById.get(member.id)!;
        const parent = member.parent_id !== null ? nodesById.get(member.parent_id) : undefined;

        if (parent) {
            parent.children.push(node);
        } else {
            roots.push(node);
        }
    });

    return roots;
}

// Card width shrinks with depth down to a floor, since the org chart has no
// maximum depth. Kept in sync with the .tier-0..3 card widths in
// OrgChartNode.vue — depths beyond the last entry reuse the smallest size.
const CARD_WIDTHS = [200, 172, 150, 140];
const ROW_GAP = 12;

export function cardWidthForDepth(depth: number): number {
    return CARD_WIDTHS[Math.min(depth, CARD_WIDTHS.length - 1)];
}

/**
 * The width a node's whole column needs: its own card, or the combined
 * width of its children's row, whichever is wider. Computed bottom-up so a
 * deeply nested branch pushes width up through every ancestor row.
 */
export function subtreeWidth(node: OrgTreeNode, depth: number): number {
    if (node.children.length === 0) {
        return cardWidthForDepth(depth);
    }

    const childrenWidth =
        node.children.reduce((sum, child) => sum + subtreeWidth(child, depth + 1), 0) +
        ROW_GAP * (node.children.length - 1);

    return Math.max(cardWidthForDepth(depth), childrenWidth);
}

/**
 * The uniform column width every sibling in a row should share, so the
 * connecting "bus" line centers correctly over each card regardless of how
 * much is nested underneath any single sibling.
 */
export function rowWidth(nodes: OrgTreeNode[], depth: number): number {
    if (nodes.length === 0) {
        return cardWidthForDepth(depth);
    }

    return Math.max(...nodes.map((node) => subtreeWidth(node, depth)));
}
